<?php

namespace Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi;

use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

class Ship extends Base
{

    /**
     * 组包提交
     * 目录：API文档/菜鸟国际出口/提供给ISV通过该接口提交发布交接单
     * api:https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21215&path=cainiao.global.handover.commit&methodType=GET/POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 16:22
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function commitBigBag(array $accountInfo, array $params = [])
    {
        if (empty($params['pickup_info'])) {
            throw new \InvalidArgumentException('参数pickup_info必填且不能为空');
        }
        if (empty($params['user_info'])) {
            throw new \InvalidArgumentException('参数user_info必填且不能为空');
        }
        if (empty($params['client'])) {
            throw new \InvalidArgumentException('参数client必填且不能为空');
        }
        $rs = static::executeRequest($accountInfo, 'cainiao.global.handover.commit', [], '', [], 'POST', function($client, $request, $accountInfo) use ($params) {
            if (!empty($params['seller_parcel_order_list'])) {
                if (is_array($params['seller_parcel_order_list']) || is_object($params['seller_parcel_order_list'])) {
                    $request->addApiParam('seller_parcel_order_list', json_encode($params['seller_parcel_order_list']));
                } else {
                    $request->addApiParam('seller_parcel_order_list', $params['seller_parcel_order_list']);
                }
            }
            if (is_array($params['pickup_info']) || is_object($params['pickup_info'])) {
                $request->addApiParam('pickup_info', json_encode($params['pickup_info']));
            } else {
                $request->addApiParam('pickup_info', $params['pickup_info']);
            }
            if (!empty($params['order_code_list'])) {
                if (is_array($params['order_code_list']) || is_object($params['order_code_list'])) {
                    $request->addApiParam('order_code_list', json_encode($params['order_code_list']));
                } else {
                    $request->addApiParam('order_code_list', $params['order_code_list']);
                }
            }
            if (!empty($params['weight'])) {
                $request->addApiParam('weight', $params['weight']);
            }
            if (!empty($params['handover_order_id'])) {
                $request->addApiParam('handover_order_id', $params['handover_order_id']);
            }
            if (!empty($params['remark'])) {
                $request->addApiParam('remark', $params['remark']);
            }
            if (!empty($params['return_info'])) {
                if (is_array($params['return_info']) || is_object($params['return_info'])) {
                    $request->addApiParam('return_info', json_encode($params['return_info']));
                } else {
                    $request->addApiParam('return_info', $params['return_info']);
                }
            }

            if (is_array($params['user_info']) || is_object($params['user_info'])) {
                $request->addApiParam('user_info', json_encode($params['user_info']));
            } else {
                $request->addApiParam('user_info', $params['user_info']);
            }
            if (!empty($params['weight_unit'])) {
                $request->addApiParam('weight_unit', $params['weight_unit']);
            }

            if (!empty($params['skip_invalid_parcel'])) {
                $request->addApiParam('skip_invalid_parcel', $params['skip_invalid_parcel']);
            } else {
                $request->addApiParam('skip_invalid_parcel', 'true');
            }

            if (!empty($params['type'])) {
                $request->addApiParam('type', $params['type']);
            }

            $request->addApiParam('client', $params['client']);
            if (!empty($params['locale'])) {
                $request->addApiParam('locale', $params['locale']);
            }
            if (!empty($params['features'])) {
                if (is_array($params['features']) || is_object($params['features'])) {
                    $request->addApiParam('features', json_encode($params['features']));
                } else {
                    $request->addApiParam('features', $params['features']);
                }
            }
            if (!empty($params['appointment_type'])) {
                $request->addApiParam('appointment_type', $params['appointment_type']);
            }
            if (!empty($params['domestic_tracking_no'])) {
                $request->addApiParam('domestic_tracking_no', $params['domestic_tracking_no']);
            }
            if (!empty($params['domestic_logistics_company_id'])) {
                $request->addApiParam('domestic_logistics_company_id', $params['domestic_logistics_company_id']);
            }
            if (!empty($params['domestic_logistics_company'])) {
                $request->addApiParam('domestic_logistics_company', $params['domestic_logistics_company']);
            }

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $rs->cainiao_global_handover_commit_response->result ?? $rs->result ?? $rs;
    }

    /**
     * 批次追加大包
     * 目录：API文档/菜鸟国际出口/批次追加大包
     * api:https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21215&path=cainiao.global.handover.content.subbag.add&methodType=POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 16:19
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function addSubBag(array $accountInfo, array $params = [])
    {
        // 参数验证和组装
        if (empty($params['user_info'])) {
            throw new \InvalidArgumentException('参数user_info必填且不能为空');
        }
        if (empty($params['add_subbag_quantity'])) {
            throw new \InvalidArgumentException('参数order_code必填且不能为空');
        }
        if (empty($params['order_code'])) {
            throw new \InvalidArgumentException('参数order_code必填且不能为空');
        }
        $rs = static::executeRequest($accountInfo, 'cainiao.global.handover.content.subbag.add', [], '', [], 'POST', function($client, $request, $accountInfo) use ($params) {
            if (is_array($params['user_info']) || is_object($params['user_info'])) {
                $request->addApiParam('user_info', json_encode($params['user_info']));
            } else {
                $request->addApiParam('user_info', $params['user_info']);
            }
            $request->addApiParam('order_code', $params['order_code']);
            $request->addApiParam('add_subbag_quantity', $params['add_subbag_quantity']);
            if (empty($params['locale'])) {
                $request->addApiParam('locale', 'zh_CN');
            } else {
                $request->addApiParam('locale', $params['locale']);
            }

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $rs->cainiao_global_handover_content_subbag_add_response->result ?? $rs->result ?? $rs;
    }

    /**
     * 获取大包面单
     * 目录：API文档/菜鸟国际出口/返回指定大包面单的PDF文件数据
     * api:https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21215&path=cainiao.global.handover.pdf.get&methodType=GET/POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 16:14
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getBigBagPdf(array $accountInfo, array $params = [])
    {
        // 参数验证和组装
        if (empty($params['user_info'])) {
            throw new \InvalidArgumentException('参数user_info必填且不能为空');
        }
        if (empty($params['client'])) {
            throw new \InvalidArgumentException('参数client必填且不能为空');
        }
        if (empty($params['handover_content_id'])) {
            throw new \InvalidArgumentException('参数handover_content_id必填且不能为空');
        }
        $rs = static::executeRequest($accountInfo, 'cainiao.global.handover.pdf.get', [], '', [], 'POST', function($client, $request, $accountInfo) use ($params) {
            if (is_array($params['user_info']) || is_object($params['user_info'])) {
                $request->addApiParam('user_info', json_encode($params['user_info']));
            } else {
                $request->addApiParam('user_info', $params['user_info']);
            }
            $request->addApiParam('client', $params['client']);
            if (!empty($params['locale'])) {
                $request->addApiParam('locale', $params['locale']);
            }

            $request->addApiParam('handover_content_id', $params['handover_content_id']);
            if (!empty($params['type'])) {
                $request->addApiParam('type', $params['type']);
            }

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $rs->cainiao_global_handover_pdf_get_response->result ?? $rs->result ?? $rs;
    }

    /**
     * 查询大包详情
     * 目录：API文档/菜鸟国际出口/查询大包详情
     * api: https://open.aliexpress.com/doc/api.htm?spm=a2o9m.11193487.0.0.35096f3dtoF70t#/api?cid=21215&path=cainiao.global.handover.pdf.get&methodType=GET/POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/19 16:12
     * @param array $accountInfo
     * @param array $params
     * @return mixed
     */
    public function getBigBagInfo(array $accountInfo, array $params = [])
    {
        if (empty($params['client'])) {
            throw new \InvalidArgumentException('参数client必填且不能为空');
        }
        $rs = static::executeRequest($accountInfo, 'cainiao.global.handover.content.query', [], '', [], 'POST', function($client, $request, $accountInfo) use ($params) {
            // 参数验证和组装
            if (!empty($params['user_info'])) {
                if (is_array($params['user_info']) || is_object($params['user_info'])) {
                    $request->addApiParam('user_info', json_encode($params['user_info']));
                } else {
                    $request->addApiParam('user_info', $params['user_info']);
                }
            }
            if (!empty($params['order_code'])) {
                $request->addApiParam('order_code', $params['order_code']);
            }
            if (!empty($params['tracking_number'])) {
                $request->addApiParam('tracking_number', $params['tracking_number']);
            }
            $request->addApiParam('client', $params['client']);
            if (!empty($params['locale'])) {
                $request->addApiParam('locale', $params['locale']);
            }

            return $client->execute($request, $accountInfo['access_token']);
        });

        return $rs->cainiao_global_handover_content_query_response->result ?? $rs->result ?? $rs;
    }

}
