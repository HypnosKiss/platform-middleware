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
 * AE-评价
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/3/19 14:49
 * @Package \Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi\Evaluation
 */
class Evaluation extends Base
{

    /**
     * 查询待卖家评价的订单信息
     * User: Sweeper
     * Time: 2022/12/27 14:24
     * @doc https://developers.aliexpress.com/doc.htm?docId=30247&docType=2
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=20896&path=aliexpress.appraise.redefining.querysellerevaluationorderlist&methodType=GET/POST
     * @param array $accountInfo 用户信息
     * @param array $params      参数数组
     * @return mixed
     */
    public function querySellerEvaluationOrderList(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.appraise.redefining.querysellerevaluationorderlist', $params, 'query_d_t_o');

        return $response->aliexpress_appraise_redefining_querysellerevaluationorderlist_response->result ?? $response->result ?? $response;
    }

    /**
     * 卖家对未评价的订单进行评价
     * User: Sweeper
     * Time: 2022/12/27 14:24
     * @doc https://developers.aliexpress.com/doc.htm?docId=30250&docType=2
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=20896&path=aliexpress.appraise.redefining.savesellerfeedback&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function saveSellerFeedback(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.appraise.redefining.savesellerfeedback', $params, 'param1');

        return $response->aliexpress_appraise_redefining_savesellerfeedback_response ?? $response;
    }

    /**
     * 查询订单已生效的评价信息
     * @doc https://developers.aliexpress.com/doc.htm?docId=35927&docType=2
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=20896&path=aliexpress.evaluation.listorderevaluation.get&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     * @author linzj
     * @date   2023-01-12 14:10
     */
    public function getListOrderEvaluation(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.evaluation.listorderevaluation.get', $params, 'trade_evaluation_request');

        return $response->aliexpress_evaluation_listorderevaluation_get_response->target_list ?? $response->target_list ?? $response;
    }

    /**
     * 回复评价
     * @doc https://developers.aliexpress.com/doc.htm?docId=35905&docType=2
     * @doc https://open.aliexpress.com/doc/api.htm#/api?cid=20896&path=aliexpress.evaluation.evaluation.reply&methodType=GET/POST
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     * @author linzj
     * @date   2023-01-12 14:27
     */
    public function replyEvaluation(array $accountInfo, array $params = [])
    {
        $response = static::executeRequest($accountInfo, 'aliexpress.evaluation.evaluation.reply', [], '', [], 'POST', function($client, $request) use ($params, $accountInfo) {
            $request->addApiParam('child_order_id', $params['child_order_id']);
            $request->addApiParam('parent_order_id', $params['parent_order_id']);
            $request->addApiParam('text', $params['text']);

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $response->aliexpress_evaluation_evaluation_reply_response->target ?? $response->target ?? $response;
    }

}
