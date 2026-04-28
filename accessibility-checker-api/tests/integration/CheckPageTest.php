<?php

use DI\Container;
use Testing\SlimTestCase;

class CheckPageTest extends SlimTestCase
{

    const INPUT_FOLDER = __DIR__ . "/input/check-page/";

    protected function setUp(): void
    {
        parent::setUp();

        $container = new Container([]);

        $this->instantiateApp($container);
    }

    // public function testNoUrl(){

    // }

    // public function testNoRules(){

    // }

    public function testImgNoAlt()
    {
        $input = file_get_contents($this::INPUT_FOLDER . "/no-alt.json");
        $request = $this->createTestRequest("POST", "/check-page", [], $input);
        $response = $this->app->handle($request);

    }

}
