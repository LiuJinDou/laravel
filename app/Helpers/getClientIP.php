<?php
//获取客户端IP
function getClientIP()
{
    if (getenv('HTTP_CLIENT_IP') && strtolower(getenv('HTTP_CLIENT_IP')) != 'unknow' && getenv('HTTP_CLIENT_IP') != 'none') {
        $onlineip = getenv('HTTP_CLIENT_IP');
    } else if (getenv('HTTP_X_FORWARDED_FOR') && strtolower(getenv('HTTP_X_FORWARDED_FOR')) != 'unknow' && getenv('HTTP_X_FORWARDED_FOR') != 'none') {
        $onlineip = getenv('HTTP_X_FORWARDED_FOR');
    } else if (getenv('REMOTE_ADDR') && strtolower(getenv('REMOTE_ADDR')) != 'unknow' && getenv('REMOTE_ADDR') != 'none') {
        $onlineip = getenv('REMOTE_ADDR');
    } else if ($_SERVER['REMOTE_ADDR'] && strtolower($_SERVER['REMOTE_ADDR']) != 'unknow' && $_SERVER['REMOTE_ADDR'] != 'none') {
        $onlineip = $_SERVER['REMOTE_ADDR'];
    }
    //$onlineip = $_SERVER['REMOTE_ADDR'];
    preg_match('/[\d\.]{7,15}/', $onlineip, $ip);
    return $ip[0] ? $ip[0] : 'unknow';
}