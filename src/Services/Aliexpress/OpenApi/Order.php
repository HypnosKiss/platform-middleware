<?php
/**
 * Created by PhpStorm.
 * User: Sweeper
 * Time: 2022/12/27 9:46
 */

namespace Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi;

use Sweeper\PlatformMiddleware\Sdk\AeSdk\IopClient;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\IopRequest;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\UrlConstants;
use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

use function GuzzleHttp\json_encode;

/**
 * OpenAPI 订单相关接口
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/3/19 15:21
 * @Package \Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi\Order
 */
class Order extends Base
{

    /**
     * 订单收货信息查询
     * User: Sweeper
     * Time: 2023/1/11 10:06
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.6dc86f3dAv7fsz#/api?cid=20905&path=aliexpress.trade.redefining.findorderreceiptinfo&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function findOrderReceiptInfo(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.trade.redefining.findorderreceiptinfo', $params, 'param1');

        return $response->aliexpress_trade_redefining_findorderreceiptinfo_response->result ?? $response->result ?? $response;
    }

    /**
     * 获取订单列表
     * User: Sweeper
     * Time: 2023/2/24 10:19
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.6dc86f3dAv7fsz#/api?cid=20905&path=aliexpress.trade.seller.orderlist.get&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getOrderList(array $accountInfo, array $params = [])
    {
        static::verifyParams(['current_page', 'page_size'], $params);
        $response = static::executeRequest($accountInfo, 'aliexpress.trade.seller.orderlist.get', $params, 'param_aeop_order_query');

        return $response->aliexpress_trade_seller_orderlist_get_response ?? $response->result ?? $response;
    }

    /**
     * 订单列表简化查询
     * User: Sweeper
     * Time: 2023/2/24 10:22
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.6dc86f3dAv7fsz#/api?cid=20905&path=aliexpress.trade.redefining.findorderlistsimplequery&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function findOrderListSimpleQuery(array $accountInfo, array $params = [])
    {
        static::verifyParams(['page', 'page_size'], $params);
        $response = static::executeRequest($accountInfo, 'aliexpress.trade.redefining.findorderlistsimplequery', $params, 'param1');

        return $response->aliexpress_trade_redefining_findorderlistsimplequery_response ?? $response->result ?? $response;
    }

    /**
     * 新版交易订单详情查询
     * User: Sweeper
     * Time: 2023/1/11 10:09
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.6dc86f3dAv7fsz#/api?cid=20905&path=aliexpress.trade.new.redefining.findorderbyid&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function findOrderById(array $accountInfo, array $params = [])
    {
        static::verifyParams(['order_id'], $params);
        $response = static::executeRequest($accountInfo, 'aliexpress.trade.new.redefining.findorderbyid', $params, 'param1');

        return $response->aliexpress_trade_new_redefining_findorderbyid_response ?? $response->result ?? $response;
    }

    /**
     * 卖家同意取消订单
     * User: Sweeper
     * Time: 2023/4/20 11:09
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=20905&path=aliexpress.trade.seller.order.acceptcancel&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params [buyer_login_id: String, order_id: Number]
     * @return mixed
     */
    public function acceptCancelOrder(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.trade.seller.order.acceptcancel', $params, 'param_order_cancel_request');

        return $response->aliexpress_trade_seller_order_acceptcancel_response ?? $response->result ?? $response;
    }

    /**
     * 卖家拒绝取消订单
     * User: Sweeper
     * Time: 2023/4/20 11:10
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=20905&path=aliexpress.trade.seller.order.refusecancel&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params ['buyer_login_id','memo','order_id']
     * @return mixed
     */
    public function refuseCancelOrder(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.trade.seller.order.refusecancel', $params, 'param_order_cancel_request', ['buyer_login_id', 'memo', 'order_id']);

        return $response->aliexpress_trade_seller_order_refusecancel_response ?? $response->result ?? $response;
    }

}
