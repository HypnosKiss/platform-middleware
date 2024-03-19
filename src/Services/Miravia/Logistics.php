<?php

namespace Sweeper\PlatformMiddleware\Services\Miravia;

use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

/**
 * AliExpress - Miravia 物流相关接口
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/2/26 16:25
 * @Package \Sweeper\PlatformMiddleware\Services\Miravia\Logistics
 */
class Logistics extends Base
{

    /**
     * Miravia包裹声明发货
     * User: Sweeper
     * Time: 2023/7/7 18:56
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21395&path=arise.logistics.pkg.shipment.declare&methodType=POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function logisticsPkgShipmentDeclare(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.logistics.pkg.shipment.declare', $params, 'package_declare_shipment_request', ['package_id_list', 'channel_type', 'seller_id']);

        return $response->arise_logistics_pkg_shipment_declare_response->result ?? $response->result ?? $response;
    }

    /**
     * Miravia物流作废包裹
     * User: Sweeper
     * Time: 2023/7/7 18:59
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21395&path=arise.logistics.repack&methodType=POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function logisticsRepack(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.logistics.repack', $params, 'repack_request', ['package_id_list', 'channel_type', 'seller_id']);

        return $response->arise_logistics_repack_response->result ?? $response->result ?? $response;
    }

    /**
     * Miravia物流修改声明发货
     * User: Sweeper
     * Time: 2023/7/7 19:02
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function logisticsShipmentUpdate(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.logistics.shipment.update', $params, 'package_update_request', ['channel_type', 'seller_id']);

        return $response->arise_logistics_shipment_update_response->result ?? $response->result ?? $response;
    }

    /**
     * Miravia物流声明发货
     * User: Sweeper
     * Time: 2023/7/7 19:05
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21395&path=arise.logistics.shipment.declare&methodType=POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function logisticsShipmentDeclare(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.logistics.shipment.declare', $params, 'declare_shipment_request', ['trade_order_id', 'trade_order_item_id_list', 'shipment_provider_code', 'tracking_number', 'channel_type', 'seller_id']);

        return $response->arise_logistics_shipment_declare_response->result ?? $response->result ?? $response;
    }

    /**
     * Miravia物流打包
     * User: Sweeper
     * Time: 2023/7/7 19:07
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21395&path=arise.logistics.pack&methodType=POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function logisticsPack(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.logistics.pack', $params, 'pack_request', ['seller_id', 'operate_way', 'trade_order_id', 'trade_order_item_id_list', 'channel_type']);

        return $response->arise_logistics_pack_response->result ?? $response->result ?? $response;
    }

    /**
     * Miravia物流打包V2
     * User: Sweeper
     * Time: 2023/7/7 19:07
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21395&path=arise.logistics.packing&methodType=POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function logisticsPacking(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.logistics.packing', $params, 'pack_request', ['seller_id', 'operate_way', 'trade_order_id', 'trade_order_item_id_list', 'channel_type']);

        return $response->arise_logistics_packing_response->result ?? $response->result ?? $response;
    }

    /**
     * Miravia物流打印面单
     * User: Sweeper
     * Time: 2023/7/7 19:10
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21395&path=arise.logistics.awb.print&methodType=GET
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function logisticsAwbPrint(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.logistics.awb.print', $params, 'print_awb_request', ['seller_id', 'package_id_list', 'channel_type', 'file_type'], 'GET');

        return $response->arise_logistics_awb_print_response ?? $response;
    }

    /**
     * Miravia物流服务商查询
     * User: Sweeper
     * Time: 2023/7/7 19:10
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21395&path=arise.logistics.shipment.provider.query&methodType=GET
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function logisticsShipmentProviderQuery(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.logistics.shipment.provider.query', $params, 'shipment_provider_request', ['seller_id', 'trade_order_id', 'trade_order_item_id_list', 'channel_type'], 'GET');

        return $response->arise_logistics_shipment_provider_query_response->result ?? $response->result ?? $response;
    }

    /**
     * Miravia物流确认妥投状态
     * User: Sweeper
     * Time: 2023/7/7 19:10
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21395&path=arise.logistics.shipment.confirm&methodType=POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function logisticsShipmentConfirm(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'arise.logistics.shipment.confirm', $params, 'package_confirm_request', ['event_code', 'seller_id', 'package_id_list', 'channel_type']);

        return $response->arise_logistics_shipment_confirm_response->result ?? $response->result ?? $response;
    }

}
