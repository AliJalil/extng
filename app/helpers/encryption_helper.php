<?php
function encrypt_decrypt($string, $action = 'encrypt'){
    $encrypt_method = "AES-256-CBC";
    $key = "!@#$";
    $iv = "!@$#%^&*^%()_+!@";

    if($action == 'encrypt'){
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }elseif($action == 'decrypt'){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
