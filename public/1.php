<?php
use Zend\Expressive\AppFactory;

chdir(dirname(__DIR__));
$loader = require 'vendor/autoload.php';

$app = AppFactory::create();
$lista_personas = ['Diego', 'Martin', 'Pablo', 'Julio', 'Andres', 'Juan'];


$app->get('/', function ($request, $response, $next) {
    $response->getBody()->write('Hola!');
    return $response;
});

$app->get('/personas{/id}', function ($request, $response, $next) use ($lista_personas) {
    $id = $request->getAttribute('id');

    if($id == null){
        return $response->getBody()->write(implode(',', $lista_personas));
    }

    $key = array_search($id, $lista_personas);
    if($key === false){
        return $response->getBody()->write('Not found');
    }

    return $response->getBody()->write($lista_personas[$key]);

});

$app->run();