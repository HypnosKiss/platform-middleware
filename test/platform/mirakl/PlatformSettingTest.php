<?php
/**
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/2/26 13:50
 */

namespace Sweeper\PlatformMiddleware\Test\platform\mirakl;

use PHPUnit\Framework\TestCase;
use Sweeper\PlatformMiddleware\platform\mirakl\PlatformSetting;
use Sweeper\PlatformMiddleware\platform\mirakl\Request;

class PlatformSettingTest extends TestCase
{

    public function testCarriers(): void
    {
        $response = PlatformSetting::instance([
            'api_url' => Request::OPEN_API_URL,
            'api_key' => $appInfo['apiKey'] ?? $appInfo['api_key'] ?? $appInfo['secretFieldValue'] ?? '59ac39c9-6d1b-4ff1-a57f-26bb835048e6',
            'shop_id' => $appInfo['shopId'] ?? $appInfo['shop_id'] ?? $appInfo['clientFieldValue'] ?? '',
        ])->setSuccessCode(-1)->carriers();

        dump($response);

        $this->assertTrue($response->isSuccess());
    }

}
