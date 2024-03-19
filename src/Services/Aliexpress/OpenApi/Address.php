<?php

namespace Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi;

use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

/**
 * 获取卖家地址信息
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/3/18 16:46
 * @Package \Sweeper\PlatformMiddleware\Services\Aliexpress\Address
 */
class Address extends Base
{

    /**
     * 获取卖家地址
     * 目录：API文档/AE-物流/获取卖家地址
     * api: https://developers.aliexpress.com/doc.htm?docId=30133&docType=2
     * api: https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193531.0.0.13b33b53KFl1Q9#/api?cid=20892&path=aliexpress.logistics.redefining.getlogisticsselleraddresses&methodType=GET/POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/18 16:46
     * @param $accountInfo
     * @return false
     */
    public function getAddressInfo($accountInfo): bool
    {
        return static::executeRequest($accountInfo, 'aliexpress.logistics.redefining.getlogisticsselleraddresses', [], 'seller_address_query', [], 'POST', function($client, $request) use ($accountInfo) {
            $request->addApiParam('seller_address_query', 'sender,pickup,refund');

            return $client->execute($request, $accountInfo['access_token']);
        });
    }

}