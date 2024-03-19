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

/**
 * OpenAPI 物流相关接口
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/3/19 15:15
 * @Package \Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi\Logistics
 */
class Logistics extends Base
{

    /**
     * 创建子交易单线上物流订单
     * User: Sweeper
     * Time: 2023/1/11 10:02
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=20892&path=aliexpress.logistics.order.createorder&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function createOrder(array $accountInfo, array $params = [])
    {
        static::verifyParams(['trade_order_from', 'trade_order_id', 'declare_product_d_t_os', 'warehouse_carrier_service', 'address_d_t_os'], $params);
        $client  = new IopClient(UrlConstants::API_GATEWAY_URL, $accountInfo['app_key'], $accountInfo['secret_key']);
        $request = new IopRequest('aliexpress.logistics.order.createorder');
        // 必填参数
        $request->addApiParam('trade_order_from', $params['trade_order_from']);
        $request->addApiParam('trade_order_id', $params['trade_order_id']);
        $request->addApiParam('declare_product_d_t_os', $params['declare_product_d_t_os']);
        $request->addApiParam('warehouse_carrier_service', $params['warehouse_carrier_service']);
        $request->addApiParam('address_d_t_os', $params['address_d_t_os']);
        // 条件非必填
        isset($params['domestic_logistics_company']) && $request->addApiParam('domestic_logistics_company', $params['domestic_logistics_company']);
        isset($params['domestic_logistics_company_id']) && $request->addApiParam('domestic_logistics_company_id', $params['domestic_logistics_company_id']);
        isset($params['domestic_tracking_no']) && $request->addApiParam('domestic_tracking_no', $params['domestic_tracking_no']);
        // 非必填参数
        isset($params['is_agree_upgrade_reverse_parcel_insure']) && $request->addApiParam('is_agree_upgrade_reverse_parcel_insure', $params['is_agree_upgrade_reverse_parcel_insure']);
        isset($params['oaid']) && $request->addApiParam('oaid', $params['oaid']);
        isset($params['pickup_type']) && $request->addApiParam('pickup_type', $params['pickup_type']);
        isset($params['package_num']) && $request->addApiParam('package_num', $params['package_num']);
        isset($params['undeliverable_decision']) && $request->addApiParam('undeliverable_decision', $params['undeliverable_decision']);
        isset($params['invoice_number']) && $request->addApiParam('invoice_number', $params['invoice_number']);
        isset($params['top_user_key']) && $request->addApiParam('top_user_key', $params['top_user_key']);
        isset($params['insurance_coverage']) && $request->addApiParam('insurance_coverage', $params['insurance_coverage']);

        $response = $client->execute($request, $accountInfo['access_token']);

        return $response->aliexpress_logistics_order_createorder_response->result ?? $response->result ?? $response;
    }

    /**
     * 查询物流订单信息（推荐）
     * 目录：API文档/AE物流/查询物流订单信息（推荐）
     * api: https://open.aliexpress.com/doc/api.htm#/api?cid=20892&path=aliexpress.logistics.querylogisticsorderdetail&methodType=GET/POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 16:01
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     * @throws \Throwable
     */
    public function getLogisticsOrderDetail(array $accountInfo, array $params = [])
    {
        // 参数验证和组装 交易订单号
        if (empty($params['trade_order_id'])) {
            throw new \InvalidArgumentException('参数trade_order_id必填且不能为空');
        }
        $rs = static::executeRequest($accountInfo, 'aliexpress.logistics.querylogisticsorderdetail', [], '', [], 'POST', function($client, $request, $accountInfo) use ($params) {
            $request->addApiParam('trade_order_id', $params['trade_order_id']);
            if (!empty($params['current_page'])) {
                $request->addApiParam('current_page', $params['current_page']);
            }                                                                                                                                                //当前页
            if (!empty($params['domestic_logistics_num'])) {
                $request->addApiParam('domestic_logistics_num', $params['domestic_logistics_num']);
            }                                                                                                                                                //国内运单号
            if (!empty($params['gmt_create_end_str'])) {
                $request->addApiParam('gmt_create_end_str', $params['gmt_create_end_str']);
            }                                                                                                                                                //起始创建时间
            if (!empty($params['gmt_create_start_str'])) {
                $request->addApiParam('gmt_create_start_str', $params['gmt_create_start_str']);
            }                                                                                                                                                //截止创建时间
            if (!empty($params['international_logistics_num'])) {
                $request->addApiParam('international_logistics_num', $params['international_logistics_num']);
            }                                                                                                                                                //国际运单号
            if (!empty($params['logistics_status'])) {
                $request->addApiParam('logistics_status', $params['logistics_status']);
            }                                                                                                                                                //订单状态
            if (!empty($params['page_size'])) {
                $request->addApiParam('page_size', $params['page_size']);
            }                                                                                                                                                //页面大小
            if (!empty($params['warehouse_carrier_service'])) {
                $request->addApiParam('warehouse_carrier_service', $params['warehouse_carrier_service']);
            }                                                                                                                                                //物流服务编码

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $rs->aliexpress_logistics_querylogisticsorderdetail_response->result ?? $rs->result ?? $rs;
    }

    /**
     * 查询仓发物流订单信息
     * 目录：API文档/AE物流/查询仓发物流订单信息
     * api: https://open.aliexpress.com/doc/api.htm#/api?cid=20892&path=aliexpress.logistics.warehouse.querydetail&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return false || object
     */
    public function getLogisticsWarehouseQueryDetail(array $accountInfo, array $params = [])
    {
        // 参数验证和组装 交易订单号
        if (empty($params['trade_order_id'])) {
            throw new \InvalidArgumentException('参数trade_order_id必填且不能为空');
        }

        $rs = static::executeRequest($accountInfo, 'aliexpress.logistics.warehouse.querydetail', [], '', [], 'POST', function($client, $request, $accountInfo) use ($params) {
            $request->addApiParam('trade_order_id', $params['trade_order_id']);
            if (!empty($params['consign_type'])) {
                $request->addApiParam('consign_type', $params['consign_type']);
            }                                             //仓发订单类型 DOMESTIC 优选仓
            if (!empty($params['current_page'])) {
                $request->addApiParam('current_page', $params['current_page']);
            }                                                                                                                                                //当前页
            if (!empty($params['domestic_logistics_num'])) {
                $request->addApiParam('domestic_logistics_num', $params['domestic_logistics_num']);
            }                                                                                                                                                //国内运单号
            if (!empty($params['gmt_create_end_str'])) {
                $request->addApiParam('gmt_create_end_str', $params['gmt_create_end_str']);
            }                                                                                                                                                //起始创建时间
            if (!empty($params['gmt_create_start_str'])) {
                $request->addApiParam('gmt_create_start_str', $params['gmt_create_start_str']);
            }                                                                                                                                                //截止创建时间
            if (!empty($params['international_logistics_num'])) {
                $request->addApiParam('international_logistics_num', $params['international_logistics_num']);
            }                                                                                                                                                //国际运单号
            if (!empty($params['logistics_status'])) {
                $request->addApiParam('logistics_status', $params['logistics_status']);
            }                                                                                                                                                //订单状态
            if (!empty($params['page_size'])) {
                $request->addApiParam('page_size', $params['page_size']);
            }                                                                                                                                                //页面大小
            if (!empty($params['warehouse_carrier_service'])) {
                $request->addApiParam('warehouse_carrier_service', $params['warehouse_carrier_service']);
            }                                                                                                                                                //物流服务编码

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $rs->aliexpress_logistics_warehouse_querydetail_response->return_result ?? $rs->return_result ?? $rs;
    }

}
