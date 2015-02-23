<?php

return array(
    'view' => (new \Slim\Views\Twig()),
    'base_url' => 'http://officium:8000/',
    'debug' => true,
    'templates.path' => BASE_DIR .'/resources/views',
    'pdo' => array(
        'default' => array(
            'dsn' => 'mysql:host=localhost;dbname=pro',
            'username' => '',
            'password' => '',
            'options' => array()
        ),
    ),
    // cookie config
    'cookies.secret_key' => getenv('SECRET_KEY'),
    'cookies.lifetime' => getenv('SECRET_KEY'),
    'cookies.cipher' => MCRYPT_RIJNDAEL_256,
    'cookies.cipher_mode' => MCRYPT_MODE_CBC
);
