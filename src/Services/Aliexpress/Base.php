<?php

namespace Sweeper\PlatformMiddleware\Services\Aliexpress;

use Sweeper\DesignPattern\Traits\MultiPattern;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\IopClient;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\IopRequest;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\UrlConstants;

abstract class Base
{

    use MultiPattern;

    /**
     * 校验必填参数
     * User: Sweeper
     * Time: 2023/1/11 11:26
     * @param array $params
     * @param array $requiredFields
     * @return bool
     */
    public static function verifyParams(array $requiredFields = [], array $params = []): bool
    {
        foreach ($requiredFields as $requiredField) {
            if (!isset($params[$requiredField])) {
                throw new \InvalidArgumentException("字段[{$requiredField}]为必填参数");
            }
        }

        return true;
    }

    /**
     * 执行 API 请求
     * User: Sweeper
     * Time: 2023/4/4 16:38
     * @param array         $accountInfo    账号信息
     * @param string        $apiName        API 名称
     * @param array         $paramVal       平台请求参数
     * @param string        $paramKey       平台请求参数 KEY
     * @param array         $requiredFields 接口必填字段，自动校验
     * @param string        $httpMethod     请求方式，默认 POST
     * @param callable|null $callback       方法不兼容/不适用可以直接指定闭包处理
     * @return mixed
     */
    public static function executeRequest(array $accountInfo, string $apiName, array $paramVal = [], string $paramKey = 'param0', array $requiredFields = [], string $httpMethod = 'POST', callable $callback = null)
    {
        $simplify = isset($paramVal['simplify']) && $paramVal['simplify'] ? 'true' : 'false';// 精简返回
        unset($paramVal['simplify']);
        static::verifyParams($requiredFields, $paramVal);
        try {
            $client  = new IopClient(UrlConstants::API_GATEWAY_URL, $accountInfo['app_key'], $accountInfo['secret_key']);
            $request = new IopRequest($apiName, $httpMethod);
            // 执行回调函数并且返回
            if ($callback && is_callable($callback)) {
                return $callback($client, $request, $accountInfo);
            }
            $paramVal && $request->addApiParam($paramKey ?: 'param0', json_encode($paramVal));
            $request->simplify = $simplify;
            $request->addApiParam('simplify', $simplify);// 设置为精简返回

            return $client->execute($request, $accountInfo['access_token']);
        } catch (\Throwable $ex) {
            throw new \RuntimeException("{$ex->getFile()}#{$ex->getLine()} ({$ex->getMessage()})");
        }
    }

}
