<?php
/**
 * Created by PhpStorm.
 * User: czq
 * Time: 2023/1/17 15:06
 */

namespace Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi;

use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

class Trade extends Base
{

    /**
     * 延长买家收货时间
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 16:55
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=20905&path=aliexpress.trade.redefining.extendsbuyeracceptgoodstime&methodType=GET/POST
     * @param array $accountInfo
     * @param       $orderId
     * @param       $day
     * @return mixed
     */
    public function extendsBuyerAcceptGoodsTime(array $accountInfo, $orderId, $day)
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.trade.redefining.extendsbuyeracceptgoodstime', [], '', [], 'POST', function($client, $request, $accountInfo) use ($orderId, $day) {
            $request->addApiParam('param0', $orderId);
            $request->addApiParam('param1', $day);

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $response->aliexpress_trade_redefining_extendsbuyeracceptgoodstime_response ?? $response;
    }

}
