<?php

namespace Sweeper\PlatformMiddleware\Sdk\AeSdk;

class IopRequest
{

    public $apiName;

    public $headerParams = [];

    public $udfParams = [];

    public $fileParams = [];

    public $httpMethod = 'POST';

    public $simplify = 'false';

    public $format = 'json';//支持TOP的xml

    public function __construct($apiName, $httpMethod = 'POST')
    {
        $this->apiName    = $apiName;
        $this->httpMethod = $httpMethod;

        if ($this->startWith($apiName, "//")) {
            throw new \InvalidArgumentException("api name is invalid. It should be start with /");
        }
    }

    /**
     * 添加API参数
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/18 17:14
     * @param $key
     * @param $value
     * @return $this
     */
    public function addApiParam($key, $value): IopRequest
    {

        if (!is_string($key)) {
            throw new \InvalidArgumentException("api param key should be string");
        }

        if (is_object($value)) {
            $this->udfParams[$key] = json_decode($value, false);
        } else {
            $this->udfParams[$key] = $value;
        }

        return $this;
    }

    /**
     * 添加文件参数
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/18 16:53
     * @param        $key
     * @param        $content
     * @param string $mimeType
     * @return $this
     */
    public function addFileParam($key, $content, string $mimeType = 'application/octet-stream'): IopRequest
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException("api file param key should be string");
        }

        $file                   = [
            'type'    => $mimeType,
            'content' => $content,
            'name'    => $key
        ];
        $this->fileParams[$key] = $file;

        return $this;
    }

    /**
     * 添加HTTP头参数
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/18 16:53
     * @param $key
     * @param $value
     * @return $this
     */
    public function addHttpHeaderParam($key, $value): IopRequest
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException("http header param key should be string");
        }

        if (!is_string($value)) {
            throw new \InvalidArgumentException("http header param value should be string");
        }

        $this->headerParams[$key] = $value;

        return $this;
    }

    /**
     * 判断字符串是否以某个字符开头
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/18 16:54
     * @param $str
     * @param $needle
     * @return bool
     */
    public function startWith($str, $needle): bool
    {
        return strpos($str, $needle) === 0;
    }

}