<?php

namespace Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi;

use Sweeper\PlatformMiddleware\Sdk\AeSdk\IopClient;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\IopRequest;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\UrlConstants;
use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

class Category extends Base
{

    /**
     * 类目预测，可以筛选卖家已经通过准入申请的类目
     * api: https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=20904&path=aliexpress.postproduct.redefining.categoryforecast&methodType=GET/POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 14:41
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     * @throws \Throwable
     */
    public function categoryForecast(array $accountInfo, array $params = [])
    {
        $c       = new IopClient(UrlConstants::API_GATEWAY_URL, $accountInfo['app_key'], $accountInfo['secret_key']);
        $request = new IopRequest('aliexpress.category.tree.list', 'GET');
        if (!empty($params['channel_seller_id'])) {
            $request->addApiParam('channel_seller_id', $params['channel_seller_id']);
        }
        if (!empty($params['only_with_permission'])) {
            $request->addApiParam('only_with_permission', $params['only_with_permission']);
        }
        if (!empty($params['channel'])) {
            $request->addApiParam('channel', $params['channel']);
        }
        if (!empty($params['category_id']) || $params['category_id'] === 0) {
            $request->addApiParam('category_id', $params['category_id']);
        }
        $rs = $c->execute($request, $accountInfo['access_token']);

        return $rs->cainiao_global_handover_content_query_response->result ?? $rs->result ?? $rs;
    }

    /**
     * 根据发布类目id、父属性路径（可选）获取子属性信息，只返回有权限品牌
     * api: https://open.aliexpress.com/doc/api.htm#/api?cid=20897&path=aliexpress.category.redefining.getchildattributesresultbypostcateidandpath&methodType=GET/POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 14:42
     * @param array $accountInfo
     * @param array $params
     * @return false|mixed
     * @throws \Throwable
     */
    public function getAttributesList(array $accountInfo, array $params = [])
    {
        $c       = new IopClient(UrlConstants::API_GATEWAY_URL, $accountInfo['app_key'], $accountInfo['secret_key']);
        $request = new IopRequest('aliexpress.category.redefining.getchildattributesresultbypostcateidandpath', 'POST');
        if (!empty($params['channel_seller_id'])) {
            $request->addApiParam('channel_seller_id', $params['channel_seller_id']);
        }
        if (!empty($params['channel'])) {
            $request->addApiParam('channel', $params['channel']);
        }
        if (!empty($params['locale'])) {
            $request->addApiParam('locale', $params['locale']);
        }
        if (!empty($params['param1'])) {
            $request->addApiParam('param1', $params['param1']);
        }
        if (!empty($params['param2'])) {
            $request->addApiParam('param2', $params['param2']);
        }

        $rs = $c->execute($request, $accountInfo['access_token']);

        return $rs->cainiao_global_handover_content_query_response->result ?? $rs->result ?? $rs;
    }

}
