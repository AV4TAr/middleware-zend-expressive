<?php
/**
 * Devolvemos un JsonResponse.
 * Headers correctos de acuerdo al content type entregado.
 */
use Zend\Expressive\AppFactory;
use Zend\Diactoros\Response\JsonResponse;

chdir(dirname(__DIR__));
$loader = require 'vendor/autoload.php';

$app = AppFactory::create();
$lista_personas = ['Diego', 'Martin', 'Pablo', 'Julio', 'Andres', 'Juan'];

$app->get('/', function ($request, $response, $next) {
    $response->getBody()->write('Hello, world!');
    return $response;
});

$app->get('/personas{/id}', function ($request, $response, $next) use ($lista_personas) {
    $id = $request->getAttribute('id');

    if($id == null){
        return new JsonResponse($lista_personas);
    }

    $key = array_search($id, $lista_personas);
    if($key === false){
        return new JsonResponse('Not found', 404);
    }

    return new JsonResponse($lista_personas[$key]);

});

$app->run();
