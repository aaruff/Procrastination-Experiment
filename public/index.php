<?php
define('BASE_DIR', __DIR__ . "/..");

require BASE_DIR . '/vendor/autoload.php';

// Environment
Dotenv::load(BASE_DIR);

// Config
$appConfig = require BASE_DIR . '/config/app.php';
$app = new Slim\Slim($appConfig);

// Database
$dbConfig = require BASE_DIR . '/config/database.php';
$dbManager = new Illuminate\Database\Capsule\Manager();
$dbManager->addConnection($dbConfig);
$dbManager->setAsGlobal();
$dbManager->bootEloquent();

// Routes
require BASE_DIR . '/app/routes.php';

// Template
$template = $app->view();
$template->parserOptions = require BASE_DIR . '/config/twig.php';
$template->parserExtensions = array(new \Slim\Views\TwigExtension());

// Cookies (4kb limit)
$cookiesConfig = require BASE_DIR . '/config/cookies.php';
$app->add(new \Slim\Middleware\SessionCookie($cookiesConfig));

$app->run();
