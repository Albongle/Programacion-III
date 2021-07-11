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
require_once "./controllers/criptoController.php";
require_once "./controllers/ventaController.php";
require_once "./controllers/informeController.php";
require_once "./middlewares/middleware.php";



date_default_timezone_set('America/Argentina/Buenos_Aires');


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();



// Instantiate App
$app = AppFactory::create();
$app->setBasePath("/SegundoParcial"); 
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


// cripto
$app->group('/cripto', function (RouteCollectorProxy $group) {
  $group->post('[/]', \CriptoController::class . ':CargarUno')->add(new Middleware("admin"));
  $group->get('[/]', \CriptoController::class . ':TraerTodos');
  $group->get('/id/[{id}]', \CriptoController::class . ':TraerUno')->add(new Middleware());
  $group->delete('[/]', \CriptoController::class . ':BorrarUno')->add(new Middleware("admin"));
  $group->post('/{id}', \CriptoController::class . ':ModificarUno')->add(new Middleware("admin"));
  

});

// venta
$app->group('/venta', function (RouteCollectorProxy $group) {
  $group->post('[/]', \VentaController::class . ':CargarUno')->add(new Middleware());
  $group->get('[/]', \VentaController::class . ':TraerTodosNacionalidad')->add(new Middleware("admin"));
  $group->get('/nombreCripto/{filtro}', \VentaController::class . ':TraerTodosUsuariosVenta')->add(new Middleware("admin"));


  

});


// informe
$app->group('/informe', function (RouteCollectorProxy $group) {
  $group->get('/todaslasventas/', \InformeController::class . ':TodasLasVentas');
  $group->get('/ventasmayorimporte/', \InformeController::class . ':VentasMayorImporte')->add(new Middleware("admin"));
  $group->get('/mastransacciones/', \InformeController::class . ':MasTransacciones')->add(new Middleware("admin"));
  $group->get('/generarcsv/{tipo}', \InformeController::class . ':GenerarCSV')->add(new Middleware("admin"));

  

});



$app->get('[/]', function (Request $request, Response $response) {    
  $response->getBody()->write("Segundo Parcial Alejandro Bongioanni");
  return $response;

});

$app->run();


?>