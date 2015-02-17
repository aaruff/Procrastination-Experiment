<?php

return array(
    'expires' => '1 month',
    'path' => '/',
    'name'=>'slim_session',
    'cookies.encrypt' => true,
    'cookies.secret_key' => getenv('SECRET_KEY'),
    'cookies.cipher' => MCRYPT_RIJNDAEL_256,
    'cookies.cipher_mode' => MCRYPT_MODE_CBC
);