<?php

/**
 * Created by Sweeper PhpStorm.
 * Author: Sweeper <wili.lixiang@gmail.com>
 * DateTime: 2024/2/26 10:50
 */

namespace Sweeper\PlatformMiddleware;

/** 定义包根目录路径 */
define("SWEEPER_PLATFORM_MIDDLEWARE_PACKAGE_ROOT_PATH", dirname(__DIR__));

if (!function_exists('camelize')) {
    /**
     * 下划线转驼峰
     * 思路:
     * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
     * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
     */
    function camelize($uncamelized_words, $separator = '_'): string
    {
        return ltrim(str_replace(' ', '', ucwords($separator . str_replace($separator, ' ', strtolower($uncamelized_words)))), $separator);
    }
}

if (!function_exists('un_camelize')) {
    /**
     * 驼峰命名转下划线命名
     * 思路:
     * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
     */
    function un_camelize($camelCaps, $separator = '_'): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1' . $separator . '$2', $camelCaps));
    }
}

if (!function_exists('json_last_error_msg')) {
    /**
     * JSON 最后一个错误消息
     * User: Sweeper
     * Time: 2023/2/24 12:31
     * json_last_error_msg(): string 成功则返回错误信息，如果没有错误产生则返回 "No error" 。
     * @return string
     */
    function json_last_error_msg(): string
    {
        static $ERRORS = [
            JSON_ERROR_NONE           => '',// No error
            JSON_ERROR_DEPTH          => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'State mismatch (invalid or malformed JSON)',
            JSON_ERROR_CTRL_CHAR      => 'Control character error, possibly incorrectly encoded',
            JSON_ERROR_SYNTAX         => 'Syntax error',
            JSON_ERROR_UTF8           => 'Malformed UTF-8 characters, possibly incorrectly encoded'
        ];

        $error = json_last_error();

        return $ERRORS[$error] ?? 'Unknown error';
    }
}

if (!function_exists('get_json_last_error')) {
    /**
     * 返回 JSON 编码解码时最后发生的错误。
     * User: Sweeper
     * Time: 2023/2/24 13:44
     * @return string
     */
    function get_json_last_error(): string
    {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = '';// No error
                break;
            case JSON_ERROR_DEPTH:
                $error = ' - Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = ' - Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = ' - Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $error = ' - Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                $error = ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $error = ' - Unknown error';
                break;
        }

        return $error;
    }
}

if (!function_exists('generate_random_string')) {

    /**
     * 生成随机字符串
     * User: Sweeper
     * Time: 2023/3/21 16:08
     * @param int $length
     * @return string
     */
    function generate_random_string(int $length = 5): string
    {
        $arr = array_merge(range('a', 'b'), range('A', 'B'), range('0', '9'));
        shuffle($arr);
        $arr = array_flip($arr);
        $arr = array_rand($arr, $length);

        return implode('', $arr);
    }
}

if (!function_exists('get_microtime')) {
    /**
     * 获取毫秒时间戳
     * User: Sweeper
     * Time: 2023/3/21 16:10
     * @return float
     */
    function get_microtime(): float
    {
        [$msec, $sec] = explode(' ', microtime());

        return (float)sprintf('%.0f', ((float)$msec + (float)$sec) * 1000);
    }
}

if (!function_exists('mb_detect_convert_encoding')) {
    /**
     * 将 string 类型 str 的字符编码从可选的 $fromEncoding 转换到 $toEncoding
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2023/10/25 17:32
     * @param string            $str          要编码的 string。
     * @param string            $toEncoding   要转换成的编码类型。
     * @param string|array|null $fromEncoding 在转换前通过字符代码名称来指定。它可以是一个 array 也可以是逗号分隔的枚举列表。 如果没有提供 from_encoding，则会使用内部（internal）编码。
     * @return string
     */
    function mb_detect_convert_encoding(string $str, string $toEncoding = 'UTF-8', $fromEncoding = null): string
    {
        return mb_convert_encoding($str, $toEncoding, $fromEncoding ?: mb_detect_encoding($str));
    }
}

if (!function_exists('vendor_path')) {
    /**
     * vendor 目录路径
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/27 13:32
     * @return string
     */
    function vendor_path(): string
    {
        $vendorPath = dirname(__DIR__, 4) . '/vendor';

        return is_dir($vendorPath) ? $vendorPath : SWEEPER_PLATFORM_MIDDLEWARE_PACKAGE_ROOT_PATH . '/vendor';
    }
}

if (!function_exists('package_path')) {
    /**
     * package 目录路径
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/27 13:32
     * @param string $packageName
     * @return string
     */
    function package_path(string $packageName = 'sweeper/platform-middleware'): string
    {
        $packagePath = vendor_path() . '/' . trim($packageName, '/\\');
        if (empty($packageName)) {
            return SWEEPER_PLATFORM_MIDDLEWARE_PACKAGE_ROOT_PATH;
        }

        return is_dir($packagePath) ? $packagePath : SWEEPER_PLATFORM_MIDDLEWARE_PACKAGE_ROOT_PATH;
    }
}

if (!function_exists('root_path')) {
    /**
     * 根目录路径
     * Author: Sweeper <wili.lixiang@gmail.com>
     * DateTime: 2024/2/27 13:32
     * @return string
     */
    function root_path(): string
    {
        return dirname(vendor_path());
    }
}

