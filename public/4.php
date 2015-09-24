<?php
/**
 * Agreguemos un middleware para Auth
 * Revisamos si hay un token
 */
use Zend\Expressive\AppFactory;
use Zend\Diactoros\Response\JsonResponse;

use Application\Auth;

chdir(dirname(__DIR__));
$loader = require 'vendor/autoload.php';
//Agregamos nuestro namesapce al autoloading
$loader->add('Application', 'src/');

$api = AppFactory::create();
$lista_personas = ['Diego', 'Martin', 'Pablo', 'Julio', 'Andres', 'Juan'];

$api->get('/', function ($request, $response, $next) {
    $response->getBody()->write('Hello, world!');
    return $response;
});

$api->get('/personas{/id}', function ($request, $response, $next) use ($lista_personas) {
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

$app = AppFactory::create();

//Cargamos el Middleware de auth
$app->pipe(new Auth());
$app->pipe($api);
$app->run();
