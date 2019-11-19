<?php

/**
 * @param $data
 * @param $method (DES-ECB、DES-CBC、DES-CTR、DES-OFB、DES-CFB)
 * @param $key
 * @return string
 */
// openssl_encrypt($data, $method, $password, $options, $iv)
function encrypt_function($data){
    return openssl_encrypt($data,'DES-ECB','blog',OPENSSL_RAW_DATA);
}

function decrypt_function($data){
    return openssl_decrypt($data,'DES-ECB','blog',OPENSSL_RAW_DATA);
}