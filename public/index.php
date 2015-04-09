<?php

/*---------------------------------------------------
 * Session
 *--------------------------------------------------- */
session_cache_limiter(false);
session_start();

define('BASE_DIR', __DIR__ . "/..");

require BASE_DIR . '/vendor/autoload.php';

/*---------------------------------------------------
 * Environment
 *--------------------------------------------------- */
Dotenv::load(BASE_DIR);

/*---------------------------------------------------
 * Slim
 *--------------------------------------------------- */
$appConfig = require BASE_DIR . '/config/app.php';

$app = new Slim\Slim($appConfig);
$app->add(new \Officium\Framework\Middleware\AuthMiddleware());

use Statical\SlimStatic\SlimStatic;
Slimstatic::boot($app);
Statical::addNamespace('*', 'Officium\\*');

/*---------------------------------------------------
 * Database
 *--------------------------------------------------- */
$dbConfig = require BASE_DIR . '/config/database.php';
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection($dbConfig);

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->setAsGlobal();

$capsule->bootEloquent();

/*---------------------------------------------------
 * Routes
 *--------------------------------------------------- */
require BASE_DIR . '/app/routes.php';

/*---------------------------------------------------
 * Twig
 *--------------------------------------------------- */
$template = $app->view();
$template->parserOptions = require BASE_DIR . '/config/twig.php';
$template->parserExtensions = array(new \Slim\Views\TwigExtension());

$app->run();
