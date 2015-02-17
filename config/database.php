<?php
return array(
    'driver' => 'mysql',
    'host' => getenv('DB_HOST'),
    'port' => '33060',
    'database' => getenv('DB_DATABASE'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
);