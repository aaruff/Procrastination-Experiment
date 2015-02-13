<?php

return array(
    'view' => new \Slim\Views\Twig(),
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
);
