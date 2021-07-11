<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Slim\Factory\AppFactory;

require __DIR__ . './persona.php';
require __DIR__ . './mw.php';
require __DIR__ . './vendor/autoload.php';
require __DIR__ . './MWparaCORS.php';

$app = AppFactory::create();
$app->setBasePath("/PruebaMDW"); 
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
// Add error middleware
$app->addErrorMiddleware(true, true, true);


$app->group('/', function (RouteCollectorProxy $group){
    $group->get('',\Persona::class . ':MostrarPersona')->add(\Mdw::class . ':miMdw');
    $group->get('persona',\Persona::class . ':MostrarPersona')->add(\Mdw::class . ':miMdw');
    $group->post('persona',\Persona::class . ':MostrarPersona')->add(\Mdw::class . ':miMdw');


})->add(\MWparaCORS::class . ':HabilitarCORS4200');

$app->run();


?>