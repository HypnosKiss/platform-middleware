<?php

use Sweeper\PlatformMiddleware\Sdk\AeSdk\Iop\Constants;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\Iop\IopClient;
use Sweeper\PlatformMiddleware\Sdk\AeSdk\Iop\IopRequest;

$c           = new IopClient('api.taobao.tw/rest', '100240', 'hLeciS15d7UsmXKoND76sBVPpkzepxex');
$c->logLevel = Constants::$log_level_debug;
$request     = new IopRequest('/product/item/get', 'GET');
$request->addApiParam('itemId', '157432005');
$request->addApiParam('authDO', '{"sellerId":2000000016002}');

var_dump($c->execute($request, null));
echo PHP_INT_MAX;
var_dump($c->msectime());