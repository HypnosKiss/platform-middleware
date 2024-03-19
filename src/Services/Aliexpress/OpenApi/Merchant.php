<?php
/**
 * Created by PhpStorm.
 * User: Sweeper
 * Time: 2023/4/4 15:52
 */

namespace Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi;

use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

/**
 * OpenAPI AE-商家相关接口
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/3/19 15:20
 * @Package \Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi\Merchant
 */
class Merchant extends Base
{

    /**
     * 商家地址列表查询
     * User: Sweeper
     * Time: 2023/4/4 17:16
     * channel_seller_id Number 请输入全托管店铺的id。 渠道seller id （可以在这个API中查询：global.seller.relation.query）， 请使用 business_type = ONE_STOP_SERVICE 的全托管店铺 channel_seller_id
     * address_types String[] 地址类型：SALESRETURN（退货地址），WAREHOUSE（发货地址）
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=20895&path=aliexpress.merchant.Address.list&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function merchantAddressList(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.merchant.Address.list', $params, 'param', ['channel_seller_id', 'address_types']);

        return $response->aliexpress_merchant_Address_list_response->result ?? $response->result ?? $response;
    }

    /**
     * 查询卖家资料，如刊登数量
     * api: https://open.aliexpress.com/doc/api.htm#/api?cid=20895&path=aliexpress.merchant.profile.get&methodType=GET/POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 16:27
     * @param array $accountInfo
     * @return mixed
     */
    public function getMerchantProfile(array $accountInfo)
    {
        $rs = static::executeRequest($accountInfo, 'aliexpress.merchant.profile.get');

        return $rs->aliexpress_merchant_profile_get_response->profile ?? $rs->profile ?? $rs;
    }

}
