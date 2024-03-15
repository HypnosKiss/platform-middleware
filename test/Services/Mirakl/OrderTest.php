<?php
/**
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/2/26 13:49
 */

namespace Sweeper\PlatformMiddleware\Test\Services\Mirakl;

use PHPUnit\Framework\TestCase;
use Sweeper\PlatformMiddleware\Services\Mirakl\Order;
use Sweeper\PlatformMiddleware\Services\Mirakl\Request;

class OrderTest extends TestCase
{

    public function testGetOrders(): void
    {
        $response = Order::instance([
            'api_url' => Request::OPEN_API_URL,
            'api_key' => $appInfo['apiKey'] ?? $appInfo['api_key'] ?? $appInfo['secretFieldValue'] ?? '59ac39c9-6d1b-4ff1-a57f-26bb835048e6',
            'shop_id' => $appInfo['shopId'] ?? $appInfo['shop_id'] ?? $appInfo['clientFieldValue'] ?? '',
        ])->setSuccessCode(-1)->getOrders();

        dump($response);

        $this->assertTrue($response->isSuccess());
    }

    public function testGetOrderDocuments(): void
    {
        $response = Order::instance([
            'api_url' => Request::OPEN_API_URL,
            'api_key' => $appInfo['apiKey'] ?? $appInfo['api_key'] ?? $appInfo['secretFieldValue'] ?? '59ac39c9-6d1b-4ff1-a57f-26bb835048e6',
            'shop_id' => $appInfo['shopId'] ?? $appInfo['shop_id'] ?? $appInfo['clientFieldValue'] ?? '',
        ])->setSuccessCode(-1)->getOrderDocuments(['C59675662-A', 'C59652563-A']);

        dump($response);

        $this->assertTrue($response->isSuccess());
    }

    public function testDownloadOrdersDocuments(): void
    {
        $response = Order::instance([
            'api_url' => Request::OPEN_API_URL,
            'api_key' => $appInfo['apiKey'] ?? $appInfo['api_key'] ?? $appInfo['secretFieldValue'] ?? '59ac39c9-6d1b-4ff1-a57f-26bb835048e6',
            'shop_id' => $appInfo['shopId'] ?? $appInfo['shop_id'] ?? $appInfo['clientFieldValue'] ?? '',
        ])->downloadOrdersDocuments(['C59675662-A', 'C59652563-A'], false);

        dump($response);

        $this->assertTrue($response->isSuccess());
    }

}
