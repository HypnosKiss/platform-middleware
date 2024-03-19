<?php
/**
 * Created by PhpStorm.
 * User: Sweeper
 * Time: 2022/12/29 15:06
 */

namespace Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi;

use Sweeper\PlatformMiddleware\Sdk\AeSdk\IopClient;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\IopRequest;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\UrlConstants;
use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

class Decrypt extends Base
{

    /**
     * 买家订单物流详情解密
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 14:46
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.6dc86f3dwkNxPS#/api?cid=20905&path=aliexpress.trade.seller.order.decrypt&methodType=GET/POST
     * @param array $accountInfo
     * @param       $orderId
     * @param       $oaid
     * @return mixed
     * @throws \Throwable
     */
    public function decrypt(array $accountInfo, $orderId, $oaid)
    {
        $client  = new IopClient(UrlConstants::API_GATEWAY_URL, $accountInfo['app_key'], $accountInfo['secret_key']);
        $request = new IopRequest('aliexpress.trade.seller.order.decrypt');
        $request->addApiParam('orderId', $orderId);
        $request->addApiParam('oaid', $oaid);
        $response = $client->execute($request, $accountInfo['access_token']);

        return $response->aliexpress_trade_seller_order_decrypt_response ?? $response;
    }

}
