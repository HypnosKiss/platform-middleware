<?php
/**
 * Created by PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2023/9/26 9:51
 */

namespace Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi;

use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

class Product extends Base
{

    /**
     * 商品查询新接口
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 17:07
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=20904&path=aliexpress.offer.product.query&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getProductDetail(array $accountInfo, array $params)
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.offer.product.query', $params, 'product_id', ['product_id'], 'POST', function($client, $request) use ($accountInfo, $params) {
            $request->addApiParam('product_id', $params['product_id']);

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $response->aliexpress_offer_product_query_response->result ?? $response->result ?? $response;
    }

    /**
     * 查询半托管已加入/待加入/待预存商品列表
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/9/26 10:10
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21439&path=aliexpress.pop.choice.products.list&methodType=GET
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getPopChoiceProductList(array $accountInfo, array $params)
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.pop.choice.products.list', $params, 'param', [], 'GET');

        return $response->aliexpress_pop_choice_products_list_response->result ?? $response->result ?? $response;
    }

    /**
     * 半托管商品详情查询
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/9/26 10:10
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21439&path=aliexpress.pop.choice.product.query&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getPopChoiceProductDetail(array $accountInfo, array $params)
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.pop.choice.product.query', $params, 'product_id', ['product_id'], 'POST', function($client, $request) use ($accountInfo, $params) {
            $request->addApiParam('product_id', $params['product_id']);
            $request->addApiParam('language', 'zh_CN');

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $response->aliexpress_pop_choice_product_query_response->result ?? $response->result ?? $response;
    }

    /**
     * AE-全托管-商品列表查询
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/9/26 10:10
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21403&path=aliexpress.choice.products.list&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getChoiceProductList(array $accountInfo, array $params)
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.choice.products.list', $params, 'param', ['channel_seller_id', 'channel', 'search_condition_do'], 'POST',
            function($client, $request) use ($accountInfo, $params) {
                $request->addApiParam('channel_seller_id', $params['channel_seller_id']);
                $request->addApiParam('channel', $params['channel']);
                $request->addApiParam('page_size', $params['page_size'] ?? 20);
                $request->addApiParam('current_page', $params['current_page'] ?? 1);
                $request->addApiParam('search_condition_do', json_encode($params['search_condition_do']));
                $request->addApiParam('version', $params['version'] ?? 1);

                return $client->execute($request, $accountInfo['access_token']);
            });

        return $response->aliexpress_choice_products_list_response->result ?? $response->result ?? $response;
    }

    /**
     * AE-全托管-全托管店铺-查询单个商品详情
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/9/26 10:10
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=21403&path=aliexpress.choice.product.query&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getChoiceProductDetail(array $accountInfo, array $params)
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.choice.product.query', $params, 'param', ['channel_seller_id', 'channel', 'product_id'], 'POST',
            function($client, $request) use ($accountInfo, $params) {
                $request->addApiParam('product_id', $params['product_id']);
                $request->addApiParam('channel_seller_id', $params['channel_seller_id']);
                $request->addApiParam('channel', $params['channel']);
                $request->addApiParam('version', $params['version'] ?? 1);

                return $client->execute($request, $accountInfo['access_token']);
            });

        return $response->aliexpress_choice_product_query_response->result ?? $response->result ?? $response;
    }

    /**
     * AE-全托管-按照商家查询仓库编码
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/9/26 10:30
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getChoiceProductWarehouseList(array $accountInfo, array $params)
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.choice.product.warehouse.list', $params, 'param', ['channel_seller_id', 'channel'], 'POST',
            function($client, $request) use ($accountInfo, $params) {
                $request->addApiParam('product_id', $params['product_id']);
                $request->addApiParam('channel_seller_id', $params['channel_seller_id']);

                return $client->execute($request, $accountInfo['access_token']);
            });

        return $response->aliexpress_choice_product_query_response->result ?? $response->result ?? $response;
    }

    /**
     * 商品删除接口
     * api: https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=20904&path=aliexpress.offer.product.delete&methodType=GET/POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 17:03
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function deleteProduct(array $accountInfo, array $params)
    {
        $rs = static::executeRequest($accountInfo, 'aliexpress.offer.product.delete', [], '', [], 'POST', function($client, $request, $accountInfo) use ($params) {
            if (!empty($params['product_id'])) {
                $request->addApiParam('product_id', $params['product_id']);
            }

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $rs->aliexpress_offer_product_delete_response->product_id ?? $rs->product_id ?? $rs;
    }

    /**
     * 商品列表查询接口
     * api: https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=20904&path=aliexpress.postproduct.redefining.findproductinfolistquery&methodType=GET/POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 17:05
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getProductsList(array $accountInfo, array $params)
    {
        $rs = static::executeRequest($accountInfo, 'aliexpress.postproduct.redefining.findproductinfolistquery', [], '', [], 'POST', function($client, $request, $accountInfo) use ($params) {
            $request->addApiParam('aeop_a_e_product_list_query', $params['aeop_a_e_product_list_query']);

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $rs->aliexpress_postproduct_redefining_findproductinfolistquery_response->result ?? $rs->result ?? $rs;
    }

    /**
     * 分页查询待优化商品列表
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 17:08
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=20904&path=aliexpress.product.diagnosis.pageQueryProblem&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getProductProblemList(array $accountInfo, array $params)
    {
        $rs = static::executeRequest($accountInfo, 'aliexpress.product.diagnosis.pageQueryProblem', [], '', [], 'POST', function($client, $request, $accountInfo) use ($params) {
            isset($params['operate_status']) && $request->addApiParam('operate_status', $params['operate_status']);
            isset($params['problem_type_list']) && $request->addApiParam('problem_type_list', $params['problem_type_list']);
            isset($params['page_size']) && $request->addApiParam('page_size', $params['page_size']);
            isset($params['current_page']) && $request->addApiParam('current_page', $params['current_page']);

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $rs->aliexpress_product_diagnosis_pageQueryProblem_response ?? $rs;
    }

    /**
     * 查询商家下待优化的商品问题类型列表
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 17:12
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=20904&path=aliexpress.product.diagnosis.queryProblem&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getProductProblemTypeList(array $accountInfo, array $params)
    {
        $rs = static::executeRequest($accountInfo, 'aliexpress.product.diagnosis.queryProblem', [], '');

        return $rs->aliexpress_product_diagnosis_queryProblem_response->product_problem_type_list ?? $rs->product_problem_type_list ?? $rs;
    }

    /**
     * 商品新的编辑接口
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 17:14
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=20904&path=aliexpress.offer.product.edit&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function editProductNew(array $accountInfo, array $params)
    {
        $rs = static::executeRequest($accountInfo, 'aliexpress.offer.product.edit', [], '', [], 'POST', function($client, $request, $accountInfo) use ($params) {
            $request->addApiParam('aeop_a_e_product', $params['aeop_a_e_product']);

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $rs->aliexpress_offer_product_edit_response->result ?? $rs->result ?? $rs;
    }

    /**
     * 商品发布新接口
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 17:15
     * @doc https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=20904&path=aliexpress.offer.product.post&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function uploadListing(array $accountInfo, array $params)
    {
        $rs = static::executeRequest($accountInfo, 'aliexpress.offer.product.post', [], '', [], 'POST', function($client, $request, $accountInfo) use ($params) {
            $request->addApiParam('aeop_a_e_product', $params['aeop_a_e_product']);

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $rs->aliexpress_offer_product_edit_response->result ?? $rs->result ?? $rs;
    }

}