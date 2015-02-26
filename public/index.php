<?php
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

/*---------------------------------------------------
 * Cookies
 *--------------------------------------------------- */
$cookiesConfig = require BASE_DIR . '/config/cookies.php';
$app->add(new \Slim\Middleware\SessionCookie($cookiesConfig));

$app->run();
