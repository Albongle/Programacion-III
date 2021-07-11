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
require_once "./controllers/hortalizaController.php";
require_once "./controllers/ventaController.php";
require_once "./controllers/informeController.php";
require_once "./middlewares/middleware.php";



date_default_timezone_set('America/Argentina/Buenos_Aires');


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();



// Instantiate App
$app = AppFactory::create();
$app->setBasePath("/PracticaSegundoExamen"); 
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
  $group->get('[/]', \UsuarioController::class . ':TraerTodos')->add(new Middleware("admin"));

});

// usuarios
$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->post('[/]', \UsuarioController::class . ':CargarUno');

});

// horatlizas
$app->group('/hortalizas', function (RouteCollectorProxy $group) {
  $group->post('[/]', \HortalizaController::class . ':CargarUno')->add(new Middleware("Admin"));
  $group->get('[/]', \HortalizaController::class . ':TraerTodos');
  $group->get('/{id}', \HortalizaController::class . ':TraerUno')->add( new Middleware("Vendedor"));
  $group->get('/tipo/{tipo}', \HortalizaController::class . ':TraerTodoTipo');
  $group->delete('/{id}', \HortalizaController::class . ':BorrarUno')->add(new Middleware("Admin"));
  $group->post('/modificar', \HortalizaController::class . ':ModificarUno')->add( new Middleware("Vendedor"));

});

// ventas
$app->group('/venta', function (RouteCollectorProxy $group) {
  $group->post('[/]', \VentaController::class . ':CargarUno')->add( new Middleware("Vendedor"));


});

// informes
$app->group('/informes', function (RouteCollectorProxy $group) {
  $group->get('/pdf/{id}', \InformeController::class . ':DescargaPDF');
  $group->get('/csv', \InformeController::class . ':GenerarCSV');
  $group->get('/ventasempleado/{id}', \InformeController::class . ':VentasEmpleado');
  $group->get('/hortalizamasvendida', \InformeController::class . ':HortalizaMasVendida');


});






$app->get('[/]', function (Request $request, Response $response) {    
  $response->getBody()->write("Segundo Parcial Alejandro Bongioanni");
  return $response;

});

$app->run();


?>