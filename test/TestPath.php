<?php
/**
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/3/15 15:33
 */

namespace Sweeper\PlatformMiddleware\Test;

use PHPUnit\Framework\TestCase;

use function Sweeper\PlatformMiddleware\package_path;
use function Sweeper\PlatformMiddleware\vendor_path;

class TestPath extends TestCase
{

    public function testRootPath(): void
    {
        $expected = dirname(__DIR__);
        $actual   = dirname(vendor_path());

        dump('===== testRootPath =====', $expected, $actual);

        $this->assertEquals($expected, $actual);
    }

    public function testVendorPath(): void
    {
        $expected = dirname(__DIR__) . '/vendor';
        $actual   = vendor_path();

        dump('===== testVendorPath =====', $expected, $actual);

        $this->assertEquals($expected, $actual);
    }

    public function testPackagePath(): void
    {
        $package  = 'sweeper/platform-middleware';
        $expected = dirname(__DIR__);
        $actual   = package_path($package);

        dump('===== testPackagePath =====', $expected, $actual);

        $this->assertEquals($expected, $actual);
    }

}