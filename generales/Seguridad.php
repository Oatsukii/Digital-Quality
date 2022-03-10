<?php
 
 class Seguridad{

/**
 * function to encrypt
 * @param string $data
 * @param string $key
 */
public function encrypt($data,$key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted=openssl_encrypt($data, "aes-256-cbc", $key, 0, $iv);
    // return the encrypted string with $iv joined 
    return base64_encode($encrypted."::".$iv);
}
 
/**
 * function to decrypt
 * @param string $data
 * @param string $key
 */
public function decrypt($data,$key)
{
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}
 
 
}
//$key="DevTI";
//$string="eERBTzlDMVNIV1ZlRFdFUWtJNmhHUT09OjrapTEXHzx4c7mA212LDI/c";

//

 /* 
$encryptado=encrypt($string,$key);
echo $encryptado;
echo "<hr>";
echo decrypt($encryptado,$key);
*/