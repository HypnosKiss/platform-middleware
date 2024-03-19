<?php

namespace Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi;

use Sweeper\PlatformMiddleware\Services\Aliexpress\Base;

class Attributes extends Base
{

    /**
     * 获取用户运费模板列表信息
     * 目录：API文档/AE-商品/AE-运费/用户运费模板列表信息
     * api: https://developers.aliexpress.com/doc.htm?docId=30126&docType=2
     * api: https://open.aliexpress.com/doc/api.htm#/api?cid=20900&path=aliexpress.freight.redefining.listfreighttemplate&methodType=GET/POST
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/3/18 17:42
     * @param $accountInfo
     * @return false
     */
    public function getAttributesList($accountInfo): ?bool
    {
        return static::executeRequest($accountInfo, 'aliexpress.freight.redefining.listfreighttemplate');
    }

}
