<?php

namespace Sweeper\PlatformMiddleware\Services\Mirakl;

use Mirakl\MMP\Shop\Request\Shipping\GetShippingCarriersRequest;
use Sweeper\GuzzleHttpRequest\Response;

/**
 * Mirakl - Catch 平台配置相关接口
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/2/26 13:16
 * @Package \Sweeper\PlatformMiddleware\Services\Mirakl\PlatformSetting
 */
class PlatformSetting extends Request
{

    /**
     * 列出所有承运商信息
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:17
     * @param array $params
     * @return Response
     */
    public function carriers(array $params = []): Response
    {
        return $this->execute($this->clientMMP(), new GetShippingCarriersRequest($params));
    }

}
