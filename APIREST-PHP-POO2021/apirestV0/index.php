<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../vendor/autoload.php';



$app = new \Slim\App([]);



$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!! ,a SlimFramework");
    return $response;

});

$app->post('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("POST => Bienvenido!!! ,a SlimFramework");
    return $response;

});
$app->put('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("PUT => Bienvenido!!! ,a SlimFramework");
    return $response;

});
$app->delete('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write(" DELETE => Bienvenido!!! ,a SlimFramework");
    return $response;

});


$app->run();