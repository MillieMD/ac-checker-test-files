<?php

namespace App\Http\Controllers;

require __DIR__ . '/../../../vendor/autoload.php';

use AccessibilityChecker\AccessibilityChecker;
use AccessibilityChecker\Validator\Validator;
use AccessibilityChecker\IdentifierType;
use Slim\Psr7\Response;
use Slim\Psr7\Request;

class APIController
{

    public function __construct(protected AccessibilityChecker $accessability_checker) {}

    public function checkPage(Request $request, Response $response): Response
    {

        $input = json_decode($request->getBody());
        $data = $this->accessability_checker->validate($input);

        $output = [
            "status" => 200,
            "data" => [
                "pages" => $data
            ]
        ];

        $response->getBody()->write(json_encode($output));

        return $response;
    }

}
