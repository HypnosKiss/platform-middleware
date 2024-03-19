<?php
/**
 * Created by PhpStorm.
 * User: Sweeper
 * Time: 2023/4/4 15:52
 */

namespace Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi;

use Sweeper\HelperPhp\Traits\RedisCache;
use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

/**
 * OpenAPI 统一跨境商家工作台-商家相关接口
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/3/19 14:56
 * @Package \Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi\GlobalSeller
 */
class GlobalSeller extends Base
{

    use RedisCache;

    /** @var string 全托管店铺类型 */
    public const BUSINESS_TYPE_TRUSTEESHIP = 'ONE_STOP_SERVICE';

    /** @var string 半托管店铺类型 */
    public const BUSINESS_TYPE_POP_CHOICE = 'POP_CHOICE';

    /**
     * 获取商家账号列表
     * User: Sweeper
     * Time: 2023/4/4 17:16
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21387&path=global.seller.relation.query&methodType=GET
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     * @response
     * //{
     * //    "seller_relation_list": {// 渠道账号列表
     * //        "seller_relation": [
     * //            {
     * //                "channel_currency": "USD", // 渠道商品币种
     * //                "channel_shop_name": "DKSHETOY Official Store", // 渠道店铺名称
     * //                "business_type": "POP_CHOICE", // 业务类型： ONE_STOP_SERVICE ： 全托管店铺； POP_CHOICE：POP与半托管店铺
     * //                "channel_seller_id": 223525827, // 渠道sellerId
     * //                "channel": "AE_GLOBAL", // 渠道标识
     * //                "seller_id": 223525827, // 全球sellerId
     * //            },
     * //        ]
     * //    },
     * //    "global_currency": "USD", // 全球商品币种
     * //    "success": true,// 成功失败
     * //    "request_id": "2102e2b216953763075105129"
     * //}
     */
    public function relationQuery(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'global.seller.relation.query', $params, 'param', [], 'GET');

        return $response->global_seller_relation_query_response->seller_relation_list ?? $response->seller_relation_list ?? $response;
    }

    /**
     * 通过缓存获取 - 商家账号列表
     * User: Sweeper
     * Time: 2023/7/19 9:52
     * @param array $accountInfo
     * @param array $params
     * @param bool  $refresh
     * @return array|mixed
     */
    public function getSellerRelationListByCache(array $accountInfo, array $params = [], $refresh = false)
    {
        $unique   = md5(json_encode($accountInfo));
        $cacheKey = "middleware_cache:aliexpress:seller_relation_list:{$unique}";

        [$cacheData, $errors] = $this->getCacheData($cacheKey, function($accountInfo, $params) {
            $result             = $this->relationQuery($accountInfo, $params);
            $sellerRelationList = json_decode(json_encode($result), true);
            $errorResponse      = $sellerRelationList['error_response'] ?? [];
            if ($errorResponse && isset($errorResponse['msg'])) {
                throw new \LogicException($errorResponse['msg']);
            }

            return $sellerRelationList['seller_relation_list']['seller_relation'] ?? $sellerRelationList['seller_relation'] ?? [];
        }, 86400, $refresh, $accountInfo, $params);

        return $cacheData;
    }

    /**
     * 获取全球卖家信息
     * User: Sweeper
     * Time: 2023/7/7 16:45
     * @param array  $accountInfo
     * @param array  $params
     * @param string $key     要获取的 key
     * @param string $channel 指定渠道名称
     * @return array|mixed
     */
    public function getGlobalSellerInfo(array $accountInfo, array $params = [], string $key = '', string $channel = 'ARISE_ES')
    {
        $sellerRelationList = $this->getSellerRelationListByCache($accountInfo, $params);
        $globalSellerInfo   = current($sellerRelationList);
        foreach ($sellerRelationList as $sellerRelation) {
            // 跳过全托管店铺渠道
            if (!empty($sellerRelation['business_type']) && $sellerRelation['business_type'] === static::BUSINESS_TYPE_TRUSTEESHIP) {
                continue;
            }
            // 指定要使用的渠道
            if (!empty($channel)) {
                if ($sellerRelation['channel'] === $channel) {
                    $globalSellerInfo = $sellerRelation;
                    break;
                }
                continue;// 没匹配中继续下一轮匹配
            }
            $globalSellerInfo = $sellerRelation;
            break;
        }

        return $key ? ($globalSellerInfo[$key] ?? $globalSellerInfo) : $globalSellerInfo;
    }

    /**
     * 获取全球卖家信息
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/9/20 17:14
     * @param array  $accountInfo
     * @param array  $params
     * @param string $businessType
     * @param string $channel
     * @param array  $where
     * @return mixed
     */
    public function getGlobalSellerInfoByWhere(array $accountInfo, array $params = [], string $businessType = self::BUSINESS_TYPE_TRUSTEESHIP, string $channel = 'AE_GLOBAL', array $where = [])
    {
        $sellerRelationList = $this->getSellerRelationListByCache($accountInfo, $params);
        $globalSellerInfo   = count($sellerRelationList) === 1 ? current($sellerRelationList) : [];
        foreach ($sellerRelationList as $sellerRelation) {
            // {
            //     "channel_currency": "USD", // 渠道商品币种
            //     "channel_shop_name": "DKSHETOY Official Store", // 渠道店铺名称
            //     "business_type": "POP_CHOICE", // 业务类型： ONE_STOP_SERVICE ： 全托管店铺； POP_CHOICE：POP与半托管店铺
            //     "channel_seller_id": 223525827, // 渠道sellerId
            //     "channel": "AE_GLOBAL", // 渠道标识
            //     "seller_id": 223525827, // 全球sellerId
            // },
            // 指定要使用的业务类型： ONE_STOP_SERVICE ： 全托管店铺； POP_CHOICE：POP与半托管店铺
            if (!empty($businessType) && (empty($sellerRelation['business_type']) || $sellerRelation['business_type'] !== $businessType)) {
                continue;// 没匹配中继续下一轮匹配
            }
            // 指定要使用的渠道标识
            if (!empty($channel) && (empty($sellerRelation['channel']) || $sellerRelation['channel'] !== $channel)) {
                continue;// 没匹配中继续下一轮匹配
            }
            foreach ($where as $key => $val) {
                if (!isset($sellerRelation[$key]) || $sellerRelation[$key] !== $val) {
                    break 2;
                }
            }
            $globalSellerInfo = $sellerRelation;
        }

        return $globalSellerInfo ?: $sellerRelationList;
    }

    /**
     * 商家半托管基本信息查询
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/9/26 10:09
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21439&path=aliexpress.pop.choice.info.query&methodType=GET
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getChoiceInfo(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.pop.choice.info.query', $params, 'param', [], 'GET');

        return $response->aliexpress_pop_choice_info_query_response->result ?? $response->result ?? $response;
    }

}
