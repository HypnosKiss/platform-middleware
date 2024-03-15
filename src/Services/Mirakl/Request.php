<?php

namespace Sweeper\PlatformMiddleware\Services\Mirakl;

use Mirakl\Core\Client\AbstractApiClient;
use Mirakl\Core\Request\AbstractRequest;
use Mirakl\MCI\Shop\Client\ShopApiClient as MCIShopApiClient;
use Mirakl\MCM\Shop\Client\ShopApiClient as MCMShopApiClient;
use Mirakl\MMP\Shop\Client\ShopApiClient as MMPShopApiClient;
use Sweeper\GuzzleHttpRequest\Response;
use Sweeper\HelperPhp\Tool\ClientRequest;

/**
 * Mirakl - Catch - 请求处理
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/2/26 13:01
 * @Package \Sweeper\PlatformMiddleware\Services\Mirakl\Request
 */
class Request extends ClientRequest
{

    public const OPEN_API_URI = 'https://marketplace.catch.com.au/';

    public const OPEN_API_URL = 'https://marketplace.catch.com.au/api/';

    /** @var string */
    public const TYPE_MCI = 'MCI';

    /** @var string */
    public const TYPE_MCM = 'MCM';

    /** @var string Marketplace for Products Seller API */
    public const TYPE_MMP = 'MMP';

    /**
     * 获取 API 服务URL
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:05
     * @return string
     */
    protected function getServerDomain(): string
    {
        return static::OPEN_API_URI;
    }

    /**
     * 获取服务请求的路径
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:05
     * @param string $path
     * @return string
     */
    protected function getServerPath(string $path): string
    {
        return $this->getVersion() ? "/api/{$this->getVersion()}/{$path}" : "/api/{$path}";
    }

    /**
     * 实例化客户端
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:05
     * @param string $type
     * @return AbstractApiClient
     */
    public function getClientByType(string $type = self::TYPE_MMP): AbstractApiClient
    {
        // Instantiating the Mirakl API Client
        switch ($type) {
            case static::TYPE_MCM:
                $shopApiClient = $this->clientMCM();
                break;
            case static::TYPE_MCI:
                $shopApiClient = $this->clientMCI();
                break;
            case static::TYPE_MMP:
            default:
                $shopApiClient = $this->clientMMP();
                break;
        }

        return $shopApiClient;
    }

    /**
     * MMP 客户端
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:05
     * @return MMPShopApiClient
     */
    public function clientMMP(): MMPShopApiClient
    {
        // Instantiating the Mirakl API Client
        $shopApiClient = new MMPShopApiClient($this->getConfig('api_url'), $this->getConfig('api_key'), $this->getConfig('shop_id'));

        return $shopApiClient->setOptions(['verify' => false, 'connect_timeout' => static::getConnectTimeout(), 'timeout' => static::getTimeout()]);
    }

    /**
     * MCI 客户端
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:05
     * @return MCIShopApiClient
     */
    public function clientMCI(): MCIShopApiClient
    {
        // Instantiating the Mirakl API Client
        $shopApiClient = new MCIShopApiClient($this->getConfig('api_url'), $this->getConfig('api_key'), $this->getConfig('shop_id'));

        return $shopApiClient->setOptions(['verify' => false, 'connect_timeout' => static::getConnectTimeout(), 'timeout' => static::getTimeout()]);
    }

    /**
     * MCM 客户端
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:05
     * @return MCMShopApiClient
     */
    public function clientMCM(): MCMShopApiClient
    {
        // Instantiating the Mirakl API Client
        $shopApiClient = new MCMShopApiClient($this->getConfig('api_url'), $this->getConfig('api_key'), $this->getConfig('shop_id'));

        return $shopApiClient->setOptions(['verify' => false, 'connect_timeout' => static::getConnectTimeout(), 'timeout' => static::getTimeout()]);
    }

    /**
     * 执行请求 -> 解析响应
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:05
     * @param AbstractApiClient $client
     * @param AbstractRequest   $request
     * @return Response
     */
    public function execute(AbstractApiClient $client, AbstractRequest $request): Response
    {
        /** @var \GuzzleHttp\Psr7\Response $result */
        // Calling the API
        // $response = $client->run($request);// $this->client()->getOrders($request); $this->client()->raw()->getOrders($request);

        return $this->resolveResponse($client->run($request));// return json_decode($result->getBody()->getContents() ?? '', true) ?: [];
    }

    /**
     * 构建头选项
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:07
     * @param string $authorization
     * @param array  $options
     * @return array
     */
    protected static function buildHeaders(string $authorization, array $options = []): array
    {
        return array_replace([
            'headers'         => [
                'Content-Type'  => 'application/json',
                'Authorization' => $authorization,
                'Accept'        => "*/*",
            ],
            'verify'          => false,
            'connect_timeout' => 10,
            'timeout'         => 60,
        ], $options);
    }

}
