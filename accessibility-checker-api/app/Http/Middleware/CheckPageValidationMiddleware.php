<?php

namespace App\Http\Middleware;

use Exception;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;

use Swaggest\JsonSchema\Schema;
use Slim\Exception\HttpBadRequestException;
use Swaggest\JsonSchema\InvalidValue;

class CheckPageValidationMiddleware implements MiddlewareInterface
{

    private $schema;

    public function __construct()
    {
        $schema_json = json_decode(file_get_contents(__DIR__ . "/../../../resources/schema/request_schema.json"));
        $this->schema = Schema::import($schema_json);
    }

    /**
     * Validate user input for the /check-page route.
     * Validates that it:
     *  - fits the schema
     *  - values are not blank
     *  - initial url is in valid format, and resolves
     * 
     * If any of these fails it will throw HttpBadRequestException with an appropriate message
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $input = json_decode($request->getBody());

        try {
            $this->schema->in($input);
        } catch (InvalidValue $e) {
            throw new HttpBadRequestException($request, "Invalid request format - ". $e->error . " at " . $e->path);
        }

        if ($input->url == "") {
            throw new HttpBadRequestException($request, "No URL provided");
            // return $this->create500Response("No URL provided");
        }

        // Check URL format
        $url_components = parse_url($input->url);

        if ($url_components == false) {
            // "Seriously malformed URL" - https://www.php.net/manual/en/function.parse-url.php
            throw new HttpBadRequestException($request, "Invalid URL format");
        }

        // Missing scheme - this is req. for file_get_contents. Assume HTTPS
        if (!isset($url_components["scheme"])) {
            throw new HttpBadRequestException($request, "URL is missing scheme");
        }

        // Check that URL can resolve
        if (!$this->urlResolves($input->url)) {
            throw new HttpBadRequestException($request, "Could not resolve URL: " . $input->url);
        }

        // Check number of rules
        // If rules.length == 0 -> nothing to check, return a message for the user
        if (count($input->rules) <= 0) {
            throw new HttpBadRequestException($request, "No rules provided");
        }
        
        $request = $request->withParsedBody($input);

        return $handler->handle($request);
    }

    private function urlResolves(string $url): bool
    {
        //  Result can be string | boolean
        $result = file_get_contents($url);

        // Strict type check for false
        if ($result === false) {
            return false;
        }

        return true;
    }

}
