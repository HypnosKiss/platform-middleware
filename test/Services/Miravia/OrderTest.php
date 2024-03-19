<?php
/**
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/3/19 17:39
 */

namespace Sweeper\PlatformMiddleware\Test\Services\Miravia;

use Sweeper\PlatformMiddleware\Services\Miravia\Order;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{

    public function testGetOrderList(): void
    {
        $accountInfo = [];
        $response    = Order::instance()->getOrderList($accountInfo, ['current_page' => 1, 'open_channel' => '', 'channel_seller_id' => '']);

        dump($response);

        static::assertIsArray($response);
    }

}
