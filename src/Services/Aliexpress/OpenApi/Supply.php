<?php
/**
 * Created by PhpStorm.
 * User: Sweeper
 * Time: 2023/4/4 15:52
 */

namespace Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi;

use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

/**
 * OpenAPI AE-供应链相关接口
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/3/19 15:22
 * @Package \Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi\Supply
 */
class Supply extends Base
{

    /** 行业账套编码[业务租户Id，全托管场景请填写5110000] AER 221000，AEG 288000 aechoice 5110000 */

    /** @var int 行业账套编码[业务租户Id] AER */
    public const BIZ_TYPE_AER = 221000;

    /** @var int 行业账套编码[业务租户Id] AEG */
    public const BIZ_TYPE_AEG = 288000;

    /** @var int 行业账套编码[业务租户Id] aechoice */
    public const BIZ_TYPE_AE_CHOICE = 5110000;

    /** 单据类型 10:普通仓发 50:JIT */

    /** @var int 订单类型 - 普通仓发 */
    public const ORDER_TYPE_NORMAL = 10;

    /** @var int 订单类型 - JIT */
    public const ORDER_TYPE_JIT = 50;

    /** 单据状态 10:待确认 15:已确认 17:待发货 20:待收货 21:已到仓 30:部分收货 40:收货完成 -99:已取消,不传则返回所有状态的采购单 */

    /** biz_type Number 是 业务租户Id，全托管场景请填写5110000 */

    /** channel_user_id Number 是 渠道seller id （可以在这个API中查询：global.seller.relation.query）， 请使用 business_type = ONE_STOP_SERVICE 的全托管店铺 channel_seller_id */

    /**
     * 采购单分页查询
     * User: Sweeper
     * Time: 2023/4/4 15:52
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.po.pageQuery&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function pageQuery(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.po.pageQuery', $params, 'param0', ['order_type', 'biz_type', 'channel_user_id']);

        return $response->aliexpress_ascp_po_pageQuery_response->result ?? $response->result ?? $response;
    }

    /**
     * 采购单确认
     * User: Sweeper
     * Time: 2023/4/4 16:17
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.po.confirmPurchaseOrder&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function confirmPurchaseOrder(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.po.confirmPurchaseOrder', $params, 'param0', ['purchase_order_no', 'biz_type', 'all_quantity_confirm', 'channel_user_id']);

        return $response->aliexpress_ascp_po_confirmPurchaseOrder_response->result ?? $response->result ?? $response;
    }

    /**
     * 创建揽收单
     * User: Sweeper
     * Time: 2023/4/4 16:50
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.po.createPickupOrder&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function createPickupOrder(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.po.createPickupOrder', $params, 'param0', [
            'order_type',
            'estimated_pickup_date',
            'biz_type',
            'estimated_weight',
            'estimated_box_number',
            'contact_info_dto',
            'estimated_volume',
            'order_no_list',
            'channel_user_id',
        ]);

        return $response->aliexpress_ascp_po_createPickupOrder_response->result ?? $response->result ?? $response;
    }

    /**
     * 查询揽收单
     * User: Sweeper
     * Time: 2023/4/4 16:54
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.po.queryPickupOrder&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function queryPickupOrder(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.po.queryPickupOrder', $params, 'param0', ['pickup_order_number', 'biz_type', 'channel_user_id']);

        return $response->aliexpress_ascp_po_queryPickupOrder_response->result ?? $response->result ?? $response;
    }

    /**
     * 打印箱唛
     * User: Sweeper
     * Time: 2023/4/4 16:58
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.po.query.createShippingMarkPdf&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function createShippingMarkPdf(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.po.query.createShippingMarkPdf', $params, 'param0', ['biz_type', 'channel_user_id', 'purchase_order_no']);

        return $response->aliexpress_ascp_po_query_createShippingMarkPdf_response->result ?? $response->result ?? $response;
    }

    /**
     * 打印货品标签
     * User: Sweeper
     * Time: 2023/4/4 16:59
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.po.createScItemBarcodePdf&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function createScItemBarcodePdf(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.po.createScItemBarcodePdf', $params, 'param0', ['purchase_order_no', 'biz_type', 'channel_user_id']);

        return $response->aliexpress_ascp_po_createScItemBarcodePdf_response->result ?? $response->result ?? $response;
    }

    /**
     * 打印揽收面单
     * User: Sweeper
     * Time: 2023/4/4 17:01
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.po.createPickupShippingMarkPdf&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function createPickupShippingMarkPdf(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.po.createPickupShippingMarkPdf', $params, 'param0', ['pickup_order_number', 'biz_type', 'channel_user_id']);

        return $response->aliexpress_ascp_po_createScItemBarcodePdf_response->result ?? $response->result ?? $response;
    }

    /**
     * AliExpress采购单明细查询API
     * User: Sweeper
     * Time: 2023/4/4 17:18
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.po.item.query&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function purchaseOrderDetail(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.po.item.query', $params, 'purchase_order_item_query', ['biz_type', 'purchase_order_no']);

        return $response->aliexpress_ascp_po_item_query_response->result ?? $response->result ?? $response;
    }

    /**
     * AliExpress采购单查询API
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/9/21 14:24
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.po.query&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function purchaseOrderQuery(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.po.query', $params, 'purchase_order_query', ['biz_type', 'purchase_order_no']);

        return $response->aliexpress_ascp_po_query_response->result ?? $response->result ?? $response;
    }

    /**
     * 采购单货品详情
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/9/20 16:58
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.item.detail&methodType=GET
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function purchaseOrderItemDetail(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.item.detail', $params, 'param0', ['sc_item_id', 'channel', 'channel_seller_id'], 'GET');

        return $response->aliexpress_ascp_item_detail_response->result ?? $response->result ?? $response;
    }

    /**
     * AliExpress货品查询API
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/9/21 13:49
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.item.query&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function purchaseOrderItemQuery(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.item.query', $params, 'sc_item_query', ['biz_type']);

        return $response->aliexpress_ascp_item_query_response->result ?? $response->result ?? $response;
    }


    /**
     * 取消揽收单
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/9/21 13:49
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21022&path=aliexpress.ascp.po.cancelPickupOrder&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function purchaseCancelPickOrder(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.ascp.po.cancelPickupOrder', $params, 'param0', ['pickup_order_number','biz_type','channel_user_id','cancel_reason']);

        return $response->aliexpress_ascp_po_cancelPickupOrder_response->result ?? $response->result ?? $response;
    }

}
