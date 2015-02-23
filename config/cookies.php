<?php

return array(
    'expires' => '1 month',
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => false,
    'name'=>'slim_session',
    'secret' => getenv('SECRET_KEY'),
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
);