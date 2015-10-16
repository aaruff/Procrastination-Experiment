<?php

return array(
    'view' => (new \Slim\Views\Twig()),
    'mode' => 'development',
    'base_url' => 'http://officium:8000/',
    'debug' => true,
    'app_debug'=> true,
    'templates.path' => BASE_DIR .'/resources/views',
    'pdo' => array(
        'default' => array(
            'dsn' => 'mysql:host=localhost;dbname=pro',
            'username' => '',
            'password' => '',
            'options' => array()
        ),
    ),
    // cookies
    'cookies.encrypt' => true,
    'cookies.secret_key' => getenv('SECRET_KEY'),
    'cookies.lifetime' => getenv('SECRET_KEY'),
    'cookies.cipher' => MCRYPT_RIJNDAEL_256,
    'cookies.cipher_mode' => MCRYPT_MODE_CBC,
    // logging
    'log.enabled' => true,
    'log.level' => \Slim\Log::DEBUG,
    'log.writer' => new \Slim\Logger\DateTimeFileWriter(['path'=>getenv('LOG_DIR')])
);
