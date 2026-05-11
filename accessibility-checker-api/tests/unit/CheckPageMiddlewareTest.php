<?php

require __DIR__ . '/../../vendor/autoload.php';

use Testing\SlimTestCase;

use DI\Container;
use Slim\Psr7\Response;
use App\Http\Controllers\APIController;
use Slim\Exception\HttpBadRequestException;
use PHPUnit\Framework\Attributes\DataProvider;

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

    public static function inputProvider(){
        return [
            ["test-no-url.json"],
            ["test-blank-url.json"],
            ["test-404-url.json"],
            ["test-invalid-url.json"],
            ["test-no-rules.json"],
            ["test-empty-rules.json"],
            ["test-no-identifier.json"],
            ["test-no-id-type.json"],
            ["test-no-id-value.json"],
            ["test-no-relationship.json"]
        ];
    }


    #[DataProvider('inputProvider')]
    public function testInvalidInput(string $file_name){
        $input = file_get_contents($this::INPUT_FOLDER . $file_name);
        $request = $this->createTestRequest("POST", "/check-page", [], $input);

        $this->expectException(HttpBadRequestException::class);

       $this->app->handle($request, new Response());     
    }

}
