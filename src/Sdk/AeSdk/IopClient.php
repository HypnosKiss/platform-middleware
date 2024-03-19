<?php

namespace Sweeper\PlatformMiddleware\Sdk\AeSdk;

use Sweeper\PlatformMiddleware\Sdk\AeSdk\Iop\IopLogger;

use function Sweeper\PlatformMiddleware\root_path;

class IopClient
{

    public $appKey;

    public $secretKey;

    public $gatewayUrl;

    public $connectTimeout;

    public $readTimeout;

    protected $signMethod = "sha256";

    protected $sdkVersion = "iop-sdk-php-20220608";

    public $logLevel;

    public $log_level_debug = "DEBUG";
    public $log_level_info  = "INFO";
    public $log_level_error = "ERROR";

    public function getAppKey()
    {
        return $this->appKey;
    }

    public function __construct($url = "", $appKey = "", $secretKey = "")
    {
        $length = strlen($url);
        if ($length === 0) {
            throw new \InvalidArgumentException("url is empty", 0);
        }
        $this->gatewayUrl = $url;
        $this->appKey     = $appKey;
        $this->secretKey  = $secretKey;
        $this->logLevel   = $this->log_level_error;
    }

    protected function generateSign($apiName, $params): string
    {
        ksort($params);

        $stringToBeSigned = '';
        if (strpos($apiName, '/')) {//rest服务协议
            $stringToBeSigned .= $apiName;
        }
        foreach ($params as $k => $v) {
            $stringToBeSigned .= "$k$v";
        }
        unset($k, $v);

        return strtoupper($this->hmac_sha256($stringToBeSigned, $this->secretKey));
    }

    public function hmac_sha256($data, $key): string
    {
        return hash_hmac('sha256', $data, $key);
    }

    public function curl_get($url, $apiFields = null, $headerFields = null)
    {
        $ch = curl_init();

        foreach ($apiFields as $key => $value) {
            $url .= "&" . "$key=" . urlencode($value);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        if ($headerFields) {
            $headers = [];
            foreach ($headerFields as $key => $value) {
                $headers[] = "$key: $value";
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            unset($headers);
        }

        if ($this->readTimeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->readTimeout);
        }

        if ($this->connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        }

        curl_setopt($ch, CURLOPT_USERAGENT, $this->sdkVersion);

        //https ignore ssl check ?
        if (strlen($url) > 5 && stripos($url, "https") === 0) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $output = curl_exec($ch);
        $errno  = curl_errno($ch);
        if ($errno) {
            curl_close($ch);
            throw new \RuntimeException($errno, 0);
        }

        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (200 !== $httpStatusCode) {
            throw new \RuntimeException($output, $httpStatusCode);
        }

        return $output;
    }

    public function curl_post($url, $postFields = null, $fileFields = null, $headerFields = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($this->readTimeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->readTimeout);
        }

        if ($this->connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        }

        if ($headerFields) {
            $headers = [];
            foreach ($headerFields as $key => $value) {
                $headers[] = "$key: $value";
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            unset($headers);
        }

        curl_setopt($ch, CURLOPT_USERAGENT, $this->sdkVersion);

        //https ignore ssl check ?
        if (strlen($url) > 5 && stripos($url, "https") === 0) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $delimiter = '-------------' . uniqid();
        $data      = '';
        if ($postFields != null) {
            foreach ($postFields as $name => $content) {
                $data .= "--" . $delimiter . "\r\n";
                $data .= 'Content-Disposition: form-data; name="' . $name . '"';
                $data .= "\r\n\r\n" . $content . "\r\n";
            }
            unset($name, $content);
        }

        if ($fileFields !== null) {
            foreach ($fileFields as $name => $file) {
                $data .= "--" . $delimiter . "\r\n";
                $data .= 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $file['name'] . "\" \r\n";
                $data .= 'Content-Type: ' . $file['type'] . "\r\n\r\n";
                $data .= $file['content'] . "\r\n";
            }
            unset($name, $file);
        }
        $data .= "--" . $delimiter . "--";

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            [
                'Content-Type: multipart/form-data; boundary=' . $delimiter,
                'Content-Length: ' . strlen($data)
            ]
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        unset($data);

        $errno = curl_errno($ch);
        if ($errno) {
            curl_close($ch);
            throw new \RuntimeException($errno, 0);
        }

        $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (200 !== $httpStatusCode) {
            throw new \RuntimeException($response, $httpStatusCode);
        }

        return $response;
    }

    public function execute(IopRequest $request, $accessToken = null)
    {
        if ($accessToken && $this->isOverdueToken($accessToken)) {
            throw new \InvalidArgumentException('token已过期，请重新授权，谢谢！！');
        }
        $sysParams["app_key"]     = $this->appKey;
        $sysParams["sign_method"] = $this->signMethod;
        $sysParams["timestamp"]   = $this->msectime();
        $sysParams["method"]      = $request->apiName;
        $sysParams["partner_id"]  = $this->sdkVersion;
        $sysParams["simplify"]    = $request->simplify;
        $sysParams["format"]      = $request->format;

        if (null !== $accessToken) {
            $sysParams["session"] = $accessToken;
        }

        $apiParams = $request->udfParams;

        $requestUrl = $this->gatewayUrl;

        if ($this->endWith($requestUrl, "/")) {
            $requestUrl = substr($requestUrl, 0, -1);
        }

        $requestUrl .= '?';

        if ($this->logLevel === $this->log_level_debug) {
            $sysParams["debug"] = 'true';
        }
        $sysParams["sign"] = $this->generateSign($request->apiName, array_merge($apiParams, $sysParams));

        foreach ($sysParams as $sysParamKey => $sysParamValue) {
            $requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
        }

        $requestUrl = substr($requestUrl, 0, -1);

        try {
            if ($request->httpMethod === 'POST') {
                $resp = $this->curl_post($requestUrl, $apiParams, $request->fileParams, $request->headerParams);
            } else {
                $resp = $this->curl_get($requestUrl, $apiParams, $request->headerParams);
            }
        } catch (\Throwable $e) {
            throw $e;
        }

        unset($apiParams);

        if (strpos($resp, 'specified access token is invalid')) {
            $this->saveOverdueToken($accessToken);
        } else {
            $this->clearOverdueToken($accessToken);
        }
        $respObject = json_decode($resp, false, 512, JSON_BIGINT_AS_STRING);
        if ($respObject === false) {
            throw new \RuntimeException('响应格式异常，解析失败;响应内容为' . $resp);
        }

        return $respObject;
    }

    protected function logApiError($requestUrl, $errorCode, $responseTxt): void
    {
        $localIp                   = $_SERVER["SERVER_ADDR"] ?? "CLI";
        $logger                    = new IopLogger;
        $logger->conf["log_file"]  = rtrim(root_path(), '\\/') . '/' . "logs/iopsdk.log." . date("Y-m-d");
        $logger->conf["separator"] = "^_^";
        $logData                   = [
            date("Y-m-d H:i:s"),
            $this->appKey,
            $localIp,
            PHP_OS,
            $this->sdkVersion,
            $requestUrl,
            $errorCode,
            str_replace("\n", "", $responseTxt)
        ];
        $logger->log($logData);
    }

    public function msectime(): string
    {
        [$msec, $sec] = explode(' ', microtime());

        return $sec . '000';
    }

    public function endWith($haystack, $needle): bool
    {
        $length = strlen($needle);
        if ($length === 0) {
            return false;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public function isOverdueToken($token): bool
    {
        $file = rtrim(root_path(), '\\/') . '/tmp/ali_overdue_token/' . $token;
        if (is_file($file)) {
            $num = file_get_contents($file);
            // 验证超过5次 或者 半小时以内创建的，不重新放行
            if ($num > 5 || (filemtime($file)) > (time() - 300)) {
                return true;
            }
        }

        return false;
    }

    public function saveOverdueToken($token): bool
    {
        $path = rtrim(root_path(), '\\/') . '/tmp/ali_overdue_token/';
        if (!is_dir($path) && !mkdir($path) && !is_dir($path)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
        }
        $file = $path . '/' . $token;
        $num  = is_file($file) ? file_get_contents($file) + 1 : 1;
        file_put_contents($file, $num);

        return true;
    }

    public function clearOverdueToken($token): void
    {
        $file = rtrim(root_path(), '\\/') . '/tmp/ali_overdue_token/' . $token;
        if (is_file($file)) {
            @unlink($file);
        }
    }

}
