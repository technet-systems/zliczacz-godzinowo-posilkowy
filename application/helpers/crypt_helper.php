<?php
/**
 * URL: http://stackoverflow.com/questions/16600708/how-do-you-encrypt-and-decrypt-a-php-string
 */

define("ENCRYPTION_KEY", "podtopola2");

/**
 * Returns an encrypted & utf8-encoded
 */
function encrypt($pure_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;

}

/**
 * Returns decrypted original string
 */
function decrypt($encrypted_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;

}

/**
 * Lekki autorski system do kryptarzu i dekryptarzu
 */

function encode($str) {
    $encode = str_split(base64_encode($str));
    foreach($encode as $key => $item) {
        if($item == "=") {
            $encode[$key] = '-61';

        } else if($item == '/') {
            $encode[$key] = '-47';
            
        }

    }

    return implode('', $encode);

}

function decode($str) {
    $str = str_replace('-61', '=', $str);
    $str = str_replace('-47', '/', $str);

    $decode = base64_decode($str);

    return $decode;

}