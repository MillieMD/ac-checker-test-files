<?php

require __DIR__ . '/../../vendor/autoload.php';

use Testing\SlimTestCase;

use Slim\Psr7\Response;

use App\Http\Controllers\APIController;
use App\Http\Middleware\CheckPageValidationMiddleware;

use DI\Container;

class RoutingTest extends SlimTestCase
{

    /**
     * Test that the router accepts valid URIs. All middleware etc. has been stubbed to return 200.
     */

    protected function setUp(): void
    {
        parent::setUp();

        $container = new Container([

            CheckPageValidationMiddleware::class => function () {
                $stub = $this->createConfiguredStub(CheckPageValidationMiddleware::class, [
                    "process" => new Response(200)
                ]);

                return $stub;
            },

            APIController::class => function () {
                $stub = $this->createConfiguredStub(APIController::class, [
                    "checkPage" => new Response(200),
                    "getValidationMethods" => new Response(200),
                    "getRequestFormat" => new Response(200)
                ]);

                return $stub;
            }
        ]);

        $this->instantiateApp($container);
    }

    public function testPostCheckPage(): void
    {
        $request = $this->createTestRequest("POST", "/check-page");
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetMethods(): void
    {
        $request = $this->createTestRequest("GET", "/method");
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetFormat(): void
    {
        $request = $this->createTestRequest("GET", "/request-format");
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(200, $response->getStatusCode());
    }
}
