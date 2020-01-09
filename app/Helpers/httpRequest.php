<?php

const CONNECT_TIMEOUT = 5;
const READ_TIMEOUT = 5;

/**
 * @see 访问远程接口
 * @param $url  远程地址
 * @param string $param 参数数组
 * @param string $method 请求方法
 * @param $connectTimeout
 * @param $readTimeout
 * @param string $header 头部信息
 * @return bool|mixed|string
 */
function httpRequest($url, $param = '', $method = 'get', $connectTimeout = CONNECT_TIMEOUT, $readTimeout = READ_TIMEOUT, $header = '')
{
//    $header = 'content-type：application/x-www-form-urlencoded;charset=UTF-8';
    $result = "";
    if (function_exists('curl_init')) {
        $timeout = $connectTimeout + $readTimeout;
        // Use CURL if installed...
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (strtolower($method) === 'post') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        }
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
    } else {
        //No curl function...
        $result = false;
    }

    return $result;
}