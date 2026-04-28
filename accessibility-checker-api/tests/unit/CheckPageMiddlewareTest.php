<?php

require __DIR__ . '/../../vendor/autoload.php';

use Testing\SlimTestCase;

use DI\Container;
use Slim\Psr7\Response;
use App\Http\Controllers\APIController;

class CheckPageMiddlewareTest extends SlimTestCase
{

    const INPUT_FOLDER = __DIR__ . "/input/request-validation-tests/";

    protected function setUp(): void
    {
        parent::setUp();

        $container = new Container([
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

    public function testNoUrl()
    {
        $input = file_get_contents($this::INPUT_FOLDER . "test-no-url.json");
        $request = $this->createTestRequest("POST", "/check-page", [], $input);
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertStringContainsString("Invalid request format", $response->getBody());

    }

    public function testBlankUrl()
    {
        $input = file_get_contents($this::INPUT_FOLDER . "test-blank-url.json");
        $request = $this->createTestRequest("POST", "/check-page", [], $input);
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals("No URL provided", $response->getBody());
    }

    public function testUrl404()
    {
        $input = file_get_contents($this::INPUT_FOLDER . "test-404-url.json");
        $request = $this->createTestRequest("POST", "/check-page", [], $input);
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertStringContainsString("Could not resolve URL", $response->getBody());
    }

    public function testInvalidUrl()
    {
        $input = file_get_contents($this::INPUT_FOLDER . "test-invalid-url.json");
        $request = $this->createTestRequest("POST", "/check-page", [], $input);
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertStringContainsString("Invalid URL format", $response->getBody());
    }

    public function testNoRules()
    {
        $input = file_get_contents($this::INPUT_FOLDER . "test-no-rules.json");
        $request = $this->createTestRequest("POST", "/check-page", [], $input);
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertStringContainsString("Invalid request format", $response->getBody());
    }

    public function testEmptyRules()
    {
        $input = file_get_contents($this::INPUT_FOLDER . "test-empty-rules.json");
        $request = $this->createTestRequest("POST", "/check-page", [], $input);
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertEquals("No rules provided", $response->getBody());
    }

    public function testNoIdentifier()
    {
        $input = file_get_contents($this::INPUT_FOLDER . "test-no-identifier.json");
        $request = $this->createTestRequest("POST", "/check-page", [], $input);
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertStringContainsString("Invalid request format", $response->getBody());
    }

    public function testNoIdType()
    {
        $input = file_get_contents($this::INPUT_FOLDER . "test-no-id-type.json");
        $request = $this->createTestRequest("POST", "/check-page", [], $input);
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertStringContainsString("Invalid request format", $response->getBody());
    }

    public function testNoIdValue()
    {
        $input = file_get_contents($this::INPUT_FOLDER . "test-no-id-value.json");
        $request = $this->createTestRequest("POST", "/check-page", [], $input);
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertStringContainsString("Invalid request format", $response->getBody());
    }

    public function testNoRelationship()
    {
        $input = file_get_contents($this::INPUT_FOLDER . "test-no-relationship.json");
        $request = $this->createTestRequest("POST", "/check-page", [], $input);
        $response = $this->app->handle($request, new Response());

        $this->assertEquals(500, $response->getStatusCode());
        $this->assertStringContainsString("Invalid request format", $response->getBody());
    }
}
