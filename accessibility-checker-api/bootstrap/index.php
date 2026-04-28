<?php 

require __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;
use App\Http\Middleware\HttpErrorHandler;

set_time_limit(600);
error_reporting(E_ERROR | E_PARSE);

$container = new Container();

$settings = require __DIR__ . '/../app/settings.php';
$settings($container);

$app = SlimAppFactory::create($container);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$errorMiddleware = new HttpErrorHandler();
$app->addMiddleware($errorMiddleware);

return $app;

?>