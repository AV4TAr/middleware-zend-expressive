<?php

Namespace Application;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Auth implements MiddlewareInterface
{
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        //Sin header no pasas
        if( !$request->hasHeader('authorization')){
            $response->getBody()->write('WTF! Unauthorized');
            return $response->withStatus(401);
        }

        //Autenticacion valida?
        if(!$this->isValid($request)){
            $response->getBody()->write('Invalid token!');
            return $response->withStatus('403');
        }

        //seguimos con la suguiente capa
        return $out($request, $response);
    }

    /**
     * Validate authorization token
     * @param Request $request
     * @return boolean
     */
    private function isValid(Request $request)
    {
        $token = $request->getHeaderLine('authorization');

        if($token == 'pasando'){
            return true;
        }
        return false;
    }
}