<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as Response;
use AutentificadorJWT as AutentificadorJWT;

class Middleware
{
    private $funcion;
    public function __construct($funcion='todos')
    {
        $this->funcion = $funcion;
    }

    
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $response =  new Response();
        $data = self::VerificarUsuario($request, $handler);
        $data = json_decode($data);
        if (isset($data->error)) {
            $response->getBody()->write($data->error);
        } else {
            switch ($this->funcion) {
                    case "todos":
                    {
                        $response = $handler->handle($request);
                        break;
                    }
                    default:
                    {
                        if ($data->token->tipo == $this->funcion) { //dentro del token levanto el dato que me interesa para evaluar
                            $response = $handler->handle($request);
                        } else {
                            $response->getBody()->write("No posee los permisos suficientes");
                        }
                        break;
                    }
                }
        }
        return $response;
    }


    private static function VerificarUsuario(Request $request, RequestHandler $handler)
    {
        if (empty($request->getHeaderLine('Authorization'))) {
            $returnAux= array("error"=>"Falta el token de verificacion");
        } else {
            try {
                $header = $request->getHeaderLine('Authorization');
                $token = trim(explode("Bearer", $header)[1]);
                AutentificadorJWT::VerificarToken($token);
                $datos = AutentificadorJWT::ObtenerData($token);
                $returnAux = array("token"=>$datos);
            } catch (Exception $ex) {
                $returnAux= array("error"=>$ex->getMessage());
            }
        }
        return json_encode($returnAux);
    }
}
