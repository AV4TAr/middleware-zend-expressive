<?php
/**
* Formateamos la respuesta en otra capa
* El middleware lee el content type y devuelve de acuerdo a ese content type
*/

use Zend\Expressive\AppFactory;
use Zend\Diactoros\Response\JsonResponse;

use Application\Auth;
//Agregamos un nuevo middleware para generar un formatter con Twig!!
use Application\Formatter;

chdir(dirname(__DIR__));
$loader = require 'vendor/autoload.php';
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
        $response->getBody()->write(implode(',', $lista_personas));
        return $next($request, $response);
    }

    $key = array_search($id, $lista_personas);
    if($key === false){
        return new JsonResponse('Not found', 404);
    }

    $response->getBody()->write($lista_personas[$key]);
    return $next($request, $response);

});

$app = AppFactory::create();

$app->pipe(new Auth());
$app->pipe($api);
//Middleware para formatear el mensaje
$app->pipe(new Formatter());
$app->run();
