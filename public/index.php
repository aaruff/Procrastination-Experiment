<?php
define('BASE_DIR', __DIR__ . "/..");

require BASE_DIR . '/vendor/autoload.php';

$config = require BASE_DIR . '/config/app.php';
$app = new Slim\Slim($config);

require BASE_DIR . '/app/routes.php';

$view = $app->view();
$view->parserOptions = array(
    'debug' => true,
    'cache' => BASE_DIR . '/storage/cache'
);
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);

$app->run();
