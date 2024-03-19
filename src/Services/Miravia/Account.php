<?php

namespace Sweeper\PlatformMiddleware\Services\Miravia;

use Sweeper\PlatformMiddleware\Sdk\AeSdk\IopClient;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\IopRequest;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\UrlConstants;
use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

/**
 * AliExpress - Miravia 账号/授权相关接口
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/3/15 15:17
 * @Package \Sweeper\PlatformMiddleware\Services\Miravia\Account
 */
class Account extends Base
{

    public const APP_KEY          = '24800759';
    public const APP_CALLBACK_URL = 'xxx';

    /**
     * 生成授权地址
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 14:47
     * @doc https://open.aliexpress.com/doc/doc.htm?nodeId=27493&docId=118729#/?docId=989
     * @param string $appKey
     * @param string $appCallbackUrl
     * @return string|string[]
     */
    public function generateAuthUrl(string $appKey = self::APP_KEY, string $appCallbackUrl = self::APP_CALLBACK_URL)
    {
        $uri = 'https://api-sg.aliexpress.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri={app_callback_url}&client_id={app_key}';

        return str_replace(['{app_callback_url}', '{app_key}'], [$appCallbackUrl ?: static::APP_CALLBACK_URL, $appKey ?: static::APP_KEY], $uri);
    }

    /**
     * 生成安全令牌
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 14:48
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=3&path=/auth/token/security/create&methodType=GET/POST
     * @param array       $accountInfo
     * @param string      $code
     * @param string|null $uuid
     * @return mixed
     */
    public function generateSecurityToken(array $accountInfo, string $code, string $uuid = null)
    {
        try {
            $client  = new IopClient(UrlConstants::API_GATEWAY_URL, $accountInfo['app_key'], $accountInfo['secret_key']);
            $request = new IopRequest('/auth/token/security/create');
            $request->addApiParam('code', $code);
            $uuid && $request->addApiParam('uuid', $uuid);

            return $client->execute($request);
        } catch (\Throwable $ex) {
            throw new \RuntimeException("{$ex->getFile()}#{$ex->getLine()} ({$ex->getMessage()})");
        }
    }

    /**
     * 生成令牌
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 14:49
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=3&path=/auth/token/create&methodType=GET/POST
     * @param array  $accountInfo
     * @param string $code
     * @param        $uuid
     * @return mixed
     */
    public function generateToken(array $accountInfo, string $code, $uuid = null)
    {
        try {
            $client  = new IopClient(UrlConstants::API_GATEWAY_URL, $accountInfo['app_key'], $accountInfo['secret_key']);
            $request = new IopRequest('/auth/token/create');
            $request->addApiParam('code', $code);
            $uuid && $request->addApiParam('uuid', $uuid);

            return $client->execute($request);
        } catch (\Throwable $ex) {
            throw new \RuntimeException("{$ex->getFile()}#{$ex->getLine()} ({$ex->getMessage()})");
        }
    }

    /**
     * 刷新安全令牌
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 14:50
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=3&path=/auth/token/security/refresh&methodType=GET/POST
     * @param array  $accountInfo
     * @param string $refreshToken
     * @return mixed
     */
    public function refreshSecurityToken(array $accountInfo, string $refreshToken)
    {
        try {
            $client  = new IopClient(UrlConstants::API_GATEWAY_URL, $accountInfo['app_key'], $accountInfo['secret_key']);
            $request = new IopRequest('/auth/token/security/refresh');
            $request->addApiParam('refresh_token', $refreshToken);

            return $client->execute($request);
        } catch (\Throwable $ex) {
            throw new \RuntimeException("{$ex->getFile()}#{$ex->getLine()} ({$ex->getMessage()})");
        }
    }

    /**
     * 刷新令牌
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 14:50
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=3&path=/auth/token/refresh&methodType=GET/POST
     * @param array  $accountInfo
     * @param string $refreshToken
     * @return mixed
     */
    public function refreshToken(array $accountInfo, string $refreshToken)
    {
        try {
            $client  = new IopClient(UrlConstants::API_GATEWAY_URL, $accountInfo['app_key'], $accountInfo['secret_key']);
            $request = new IopRequest('/auth/token/refresh');
            $request->addApiParam('refresh_token', $refreshToken);

            return $client->execute($request);
        } catch (\Throwable $ex) {
            throw new \RuntimeException("{$ex->getFile()}#{$ex->getLine()} ({$ex->getMessage()})");
        }
    }

}
