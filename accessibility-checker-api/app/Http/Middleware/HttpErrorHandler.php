<?php

namespace App\Http\Middleware;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

use Slim\Exception\HttpException;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Exception\HttpSpecializedException;
use Slim\Psr7\Response;

class HttpErrorHandler implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $response = new Response();

        try {
            $response = $handler->handle($request);
        }catch(Exception $e){
            $response = $this->handleException($e);
        }

        return $response;
    }

    public function handleException(Exception $e): ResponseInterface{

        $error = [
            "status" => 500,
            "error" => [
                "message" => "Sorry, something went wrong!",
                "details" => [
                    "debug-message" => $e->getMessage(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine()
                ]
            ]
        ];

        if($e instanceof HttpSpecializedException){
            $error["status"] = $e->getCode();
            $error["error"]["message"] = $e->getMessage();
        }

        $response = new Response($error["status"]);
        $response->getBody()->write(json_encode($error));

        return $response;

    }

}
