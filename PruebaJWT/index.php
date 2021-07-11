<?php
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;
use Slim\Exception\NotFoundException;
use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . './vendor/autoload.php';
require_once "./controllers/usuarioController.php";
require_once "./middlewares/MdwAccesos.php";


date_default_timezone_set('America/Argentina/Buenos_Aires');


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();



// Instantiate App
$app = AppFactory::create();
$app->setBasePath("/PruebaJWT"); 
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
// Add error middleware
$app->addErrorMiddleware(true, true, true);


// Eloquent
$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => $_ENV['MYSQL_HOST'],
    'database'  => $_ENV['MYSQL_DB'],
    'username'  => $_ENV['MYSQL_USER'],
    'password'  => $_ENV['MYSQL_PASS'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// login
$app->group('/login', function (RouteCollectorProxy $group) {
  $group->post('[/]', \UsuarioController::class . ':login');
  $group->get('[/]', \UsuarioController::class . ':VerificarUsuario');

});

// usuarios
$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->post('[/]', \UsuarioController::class . ':CargarUno');
  $group->get('[/]', \UsuarioController::class . ':TraerTodos')->add(\UsuarioController::class . ':VerificarUsuario');

});



$app->get('[/]', function (Request $request, Response $response) {    
  $response->getBody()->write("Prueba JWT Alejandro Bongioanni");
  return $response;

});

$app->run();


?>