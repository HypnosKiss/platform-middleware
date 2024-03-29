<?php

namespace Sweeper\PlatformMiddleware\Sdk\AeSdk\Iop;

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

    public function addApiParam($key, $value)
    {

        if (!is_string($key)) {
            throw new \InvalidArgumentException("api param key should be string");
        }

        if (is_object($value)) {
            $this->udfParams[$key] = json_decode($value);
        } else {
            $this->udfParams[$key] = $value;
        }
    }

    public function addFileParam($key, $content, $mimeType = 'application/octet-stream')
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
    }

    public function addHttpHeaderParam($key, $value)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException("http header param key should be string");
        }

        if (!is_string($value)) {
            throw new \InvalidArgumentException("http header param value should be string");
        }

        $this->headerParams[$key] = $value;
    }

    public function startWith($str, $needle)
    {
        return strpos($str, $needle) === 0;
    }

}