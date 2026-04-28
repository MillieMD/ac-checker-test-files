<?php

use Slim\App;
use App\Http\Controllers\APIController;

use App\Http\Middleware\CheckPageValidationMiddleware;

return function (App $app) {

    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    });

    $app->post('/check-page', [APIController::class, "checkPage"])->add(CheckPageValidationMiddleware::class);

    $app->get("/test/no-alt", function ($request, $response) {
        $response->getBody()->write(file_get_contents("../resources/html/test/no-alt.html"));
        return $response;
    });

    $app->get("/test/sitemap", function ($request, $response) {
        $response->getBody()->write(file_get_contents("../resources/html/test/sitemap.xml"));
        return $response;
    });

    $app->get("/test/page-1", function ($request, $response) {
        $response->getBody()->write(file_get_contents("../resources/html/test/page-1.html"));
        return $response;
    });

    $app->get("/test/page-2", function ($request, $response) {
        $response->getBody()->write(file_get_contents("../resources/html/test/page-2.html"));
        return $response;
    });
};
