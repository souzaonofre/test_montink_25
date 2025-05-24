<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Onofre\TestMontink25\System\App\Application;
use Onofre\TestMontink25\System\App\Dispatcher;
use Onofre\TestMontink25\System\Http\ServerHttpFactory;

// Code base directory
define("BASE_DIR", __DIR__ . "/../");

// Web public directory
define("PUBLIC_DIR", __DIR__);

// App code base directory
define("APP_DIR", __DIR__ . "/../src");

$config_data = require __DIR__ . "/../setup/config.php";
$routes_data = require __DIR__ . "/../setup/routes.php";

// App container Id's constant
const APP_ROUTES = 'app-routes';
const APP_CONFIG = 'app-config';

// App instance
$app = (new Application(BASE_DIR))
    ->set(APP_ROUTES, $routes_data)
    ->set(APP_CONFIG, $config_data)
    ->setRequest(ServerHttpFactory::createRequestFromGlobals())
    ->setResponse(ServerHttpFactory::createResponse())
    ->setDispacther(new Dispatcher());

// App output response
echo $app->dispatch()->response();
exit;
