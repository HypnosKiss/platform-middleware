<?php
/**
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/3/19 18:06
 */

namespace Sweeper\PlatformMiddleware\Test\Services\Aliexpress\OpenApi;

use Sweeper\PlatformMiddleware\Services\Aliexpress\OpenApi\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{

    public function testGetOrderList()
    {
        $accountInfo = [];
        $response    = Order::instance()->getOrderList($accountInfo, ['current_page' => 1, 'page_size' => 50]);

        dump($response);

        static::assertIsArray($response);
    }

}
