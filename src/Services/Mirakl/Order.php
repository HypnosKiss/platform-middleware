<?php

namespace Sweeper\PlatformMiddleware\Services\Mirakl;

use Mirakl\MMP\Shop\Request\Order\Document\DownloadOrdersDocumentsRequest;
use Mirakl\MMP\Shop\Request\Order\Document\GetOrderDocumentsRequest;
use Mirakl\MMP\Shop\Request\Order\Get\GetOrdersRequest;
use Mirakl\MMP\Shop\Request\Order\Tracking\UpdateOrderTrackingInfoRequest;
use Sweeper\GuzzleHttpRequest\Response;

/**
 * Mirakl - Catch 订单相关接口
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/2/26 13:18
 * @Package \Sweeper\PlatformMiddleware\Services\Mirakl\Order
 */
class Order extends Request
{

    /**
     * 获取订单列表
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:42
     * @doc https://help.mirakl.net/help/api-doc/seller/mmp.html#OR11
     * @param array $params
     * @return Response
     */
    public function getOrders(array $params = []): Response
    {
        // Building request
        $request = new GetOrdersRequest($params);

        // Calling the API
        // $response = $this->clientMMP()->run($request);
        // $response = $this->clientMMP()->getOrders($request);
        // $response = $this->clientMMP()->raw()->getOrders($request);
        return $this->execute($this->clientMMP(), $request);
    }

    /**
     * 接受或拒绝订单行
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:44
     * @doc https://help.mirakl.net/help/api-doc/seller/mmp.html#OR21
     * @param string $orderId
     * @param array  $orderLines {'order_lines':[{'accepted':true,'id':'Order_00012-B-1'}]}
     * @return Response
     */
    public function acceptRefuseOrder(string $orderId, array $orderLines): Response
    {
        // return static::handleResponse($this->clientMMP()->run(new AcceptOrderRequest($orderId, $orderLines)));// 官方SDK调不通，不知道错误信息，只提示400
        return static::put($this->buildRequestUri("orders/{$orderId}/accept"), $orderLines, static::buildHeaders($this->getConfig('api_key')));
    }

    /**
     * 取消订单
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:45
     * @doc https://help.mirakl.net/help/api-doc/seller/mmp.html#OR29
     * @param string $orderId
     * @return Response
     */
    public function cancelOrder(string $orderId): Response
    {
        // return static::handleResponse($this->clientMMP()->run(new CancelOrderRequest($orderId)));
        return static::put($this->buildRequestUri("orders/{$orderId}/cancel"), [], static::buildHeaders($this->getConfig('api_key')));
    }

    /**
     * 更新特定订单的承运商跟踪信息
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:45
     * @doc https://help.mirakl.net/help/api-doc/seller/mmp.html#OR23
     * @param string $orderId
     * @param array  $trackingOrderInfo {'carrier_code':'UPS','carrier_name':'UPS','carrier_url':'https://ups.com','tracking_number':'5555'}
     * @return Response
     */
    public function updateOrderTrackingInfo(string $orderId, array $trackingOrderInfo): Response
    {
        return $this->execute($this->clientMMP(), new UpdateOrderTrackingInfoRequest($orderId, $trackingOrderInfo));
    }

    /**
     * 获取订单文档
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:46
     * @doc https://help.mirakl.net/help/api-doc/seller/mmp.html#OR72
     * @param array $orderIds
     * @return Response
     * @throws \Mirakl\Core\Exception\RequestValidationException
     */
    public function getOrderDocuments(array $orderIds): Response
    {
        // Building request
        $request = new GetOrderDocumentsRequest($orderIds);

        // Calling the API
        return $this->execute($this->clientMMP(), $request);
    }

    /**
     * 下载订单文档
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:47
     * @doc https://help.mirakl.net/help/api-doc/seller/mmp.html#OR73
     * @param array $orderIds
     * @param bool  $download
     * @return Response
     */
    public function downloadOrdersDocuments(array $orderIds, bool $download = false): Response
    {
        // Building request
        $request = new DownloadOrdersDocumentsRequest();
        $request->setOrderIds($orderIds);
        $result = $this->clientMMP()->downloadOrdersDocuments($request);
        if ($download) {
            $result->download();
        }
        if (ob_get_length()) {
            ob_clean();
        }
        $result->getFile()->rewind();

        return Response::success('Success', [$result->getFile()->fpassthru()]);
    }

    /**
     * 校验订单发货 Valid the shipment of the order
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/26 13:48
     * @doc https://help.mirakl.net/help/api-doc/seller/mmp.html#OR24
     * @param string $orderId
     * @return Response
     */
    public function shipOrder(string $orderId): Response
    {
        // return static::handleResponse($this->clientMMP()->run(new ShipOrderRequest($orderId)));
        return static::put($this->buildRequestUri("orders/{$orderId}/ship"), [], static::buildHeaders($this->getConfig('api_key')));
    }

}
