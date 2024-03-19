<?php

namespace Sweeper\PlatformMiddleware\Services\Miravia;

use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

/**
 * AliExpress - Miravia 订单相关接口
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/2/26 16:25
 * @Package \Sweeper\PlatformMiddleware\Services\Miravia\Order
 */
class Order extends Base
{

    /**
     * Miravia订单列表查询
     * User: Sweeper
     * Time: 2023/7/7 10:58
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21394&path=arise.order.list.query&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getOrderList(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.order.list.query', $params, 'param0', ['current_page', 'open_channel', 'channel_seller_id']);

        return $response->arise_order_list_query_response->result ?? $response->result ?? $response;
    }

    /**
     * Miravia订单详情查询
     * User: Sweeper
     * Time: 2023/7/7 10:58
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21394&path=arise.order.detail.query&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getOrderDetail(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.order.detail.query', $params, 'param0', ['trade_order_id', 'open_channel', 'channel_seller_id']);

        return $response->arise_order_detail_query_response->result ?? $response->result ?? $response;
    }

    /**
     * Miravia订单设置备注
     * User: Sweeper
     * Time: 2023/7/7 10:58
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21394&path=arise.order.memo.set&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function setMemo(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.order.memo.set', $params, 'param0', ['trade_order_id', 'open_channel', 'channel_seller_id']);

        return $response->arise_order_memo_set_response->result ?? $response->result ?? $response;
    }

}
