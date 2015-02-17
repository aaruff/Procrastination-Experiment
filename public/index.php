<?php
define('BASE_DIR', __DIR__ . "/..");

require BASE_DIR . '/vendor/autoload.php';

Dotenv::load(BASE_DIR);

$appConfig = require BASE_DIR . '/config/app.php';
$app = new Slim\Slim($appConfig);

$dbConfig = require BASE_DIR . '/config/database.php';
$dbManager = new Illuminate\Database\Capsule\Manager();
$dbManager->addConnection($dbConfig);
$dbManager->setAsGlobal();
$dbManager->bootEloquent();


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
