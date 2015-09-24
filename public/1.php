<?php
/**
* API de personas con 2 endpoints
*    /personas           - Lista todas las peronas
*    /personas/:Persona  - Lista una sola persona
*
* En este caso usaremos como store un array preconfigurado.
*/

use Zend\Expressive\AppFactory;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$app = AppFactory::create();
$lista_personas = ['Diego', 'Martin', 'Pablo', 'Julio', 'Andres', 'Juan'];

$app->get('/personas{/id}', function ($request, $response, $next) use ($lista_personas) {
    $id = $request->getAttribute('id');

    if($id == null){
        /**
        * Modificamos el body del response y lo retornamos
        * Al retornar el response se corta la ejecucion y se despliega el mismo.
        */
        return $response->getBody()->write(implode(',', $lista_personas));
    }

    $key = array_search($id, $lista_personas);
    if($key === false){
        return $response->getBody()->write('Not found');
    }

    return $response->getBody()->write($lista_personas[$key]);

});

$app->run();