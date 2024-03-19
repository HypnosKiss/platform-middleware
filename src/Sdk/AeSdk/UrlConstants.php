<?php

namespace Sweeper\PlatformMiddleware\Sdk\AeSdk;

class UrlConstants
{

    /** @var string API 网关地址 */
    public const API_GATEWAY_URL = 'https://api-sg.aliexpress.com/sync';

    public static $api_gateway_url_tw = self::API_GATEWAY_URL;
    public const API_GATEWAY_URL_TW_NEW = "http://api-sg.aliexpress.com/rest";

}
