<?php

Namespace Application;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class Diego implements MiddlewareInterface
{
    
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
       
    }
}