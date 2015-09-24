<?php
use Zend\Expressive\AppFactory;
use Zend\Diactoros\Response\JsonResponse;

chdir(dirname(__DIR__));
$loader = require 'vendor/autoload.php';

$app = AppFactory::create();


$app->get('/', function ($request, $response, $next) {
    $response->getBody()->write('Hola!');
    return $response;
});

$app->run();