<?php

namespace Testing;

use App\Http\Controllers\APIController;
use PHPUnit\Framework\TestCase;

use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Request;

abstract class SlimTestCase extends TestCase{

    /**
     * Facilitate testing the app as it would run
     */

    protected $app;
    protected $serverRequestFactory;

    protected function setUp() : void{

        $this->serverRequestFactory = new ServerRequestFactory();

        $container = new Container();
        $this->instantiateApp($container);

    }

    /**
     * Instantiate the app in a SlimTestCase, allows for mocking of dependencies.
     */
    protected function instantiateApp(Container $container){
        $settings = require __DIR__ . '/../app/settings.test.php';
        $settings($container);

        $app = SlimAppFactory::create($container);

        $routes = require __DIR__ . '/../app/routes.php';
        $routes($app);

        $this->app = $app;
    }

    /**
     * Create a request object for testing
     */
    protected function createTestRequest(string $method, string $uri, array $serverParams = [], $body = null) : Request{
        $request = $this->serverRequestFactory->createServerRequest($method, $uri, $serverParams);
        
        if($body !== null){
            $request->getBody()->write($body);
        }
        
        return $request;

    }

}

?>