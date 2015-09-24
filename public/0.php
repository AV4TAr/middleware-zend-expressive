<?php
use Zend\Expressive\AppFactory;
use Zend\Diactoros\Response\JsonResponse;

chdir(dirname(__DIR__));
$loader = require 'vendor/autoload.php';

$app = AppFactory::create();

// Usando Aura.Router para generar la primer pagina
$app->get('/', function ($request, $response, $next) {
    $response->getBody()->write('Hola!');
    return $response;
});

$app->run();