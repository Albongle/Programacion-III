<?php
require_once "./models/usuario.php";
require_once "./interfaces/IApiUsable.php";
require_once "./middlewares/AutentificadorJWT.php";
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use App\Models\Usuario as Usuario;
use AutentificadorJWT as AutentificadorJWT;

class UsuarioController implements IApiUsable
{
    private static $claveSecreta = 'ClaveSuperSecreta@';
    private static $tipoEncriptacion = ['HS256'];
    public function CargarUno(Request $request, Response $response, $args)
    {
        $parametros = $request->getParsedBody();
        if (isset($parametros['nombre']) && isset($parametros['mail']) && isset($parametros['password']) && isset($parametros['tipo'])) {
            if (!Usuario::where('mail', '=', $parametros['mail'])->first()) {
                $usr = new Usuario();
                $usr->nombre = $parametros['nombre'];
                $usr->mail= $parametros['mail'];
                $usr->pass = $parametros['password'];
                $usr->tipo = $parametros['tipo'];
                $usr->save();
                $payload = json_encode(array("mensaje" => "Usuario creado con exito"));
            } else {
                $payload = json_encode(array("mensaje" => "mail existente en BD", "mail"=> $parametros['mail']));
            }
        } else {
            $payload = json_encode(array("mensaje" => "No se recibio alguno de los parametros necesarios para el alta de Usuario"));
        }
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodos(Request $request, Response $response, $args)
    {
        $lista = Usuario::all();
        $payload = json_encode(array("listaUsuario" => $lista));
  
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    /**
     * Metodo que genera el token del usuario previa validacion en BD
     */
    public function Login(Request $request, Response $response)
    {
        $parametros = $request->getParsedBody();
        if (isset($parametros['mail']) && isset($parametros['clave'])) {
            $usuario =  Usuario::Where('mail', '=', $parametros['mail'])->where('pass', '=', $parametros['clave'])->first();
            if ($usuario) {
                $datos = [
                    "Id" => $usuario->idusuarios,
                    "Nombre" => $usuario->nombre, "Mail" => $usuario->mail,
                    "Tipo" => $usuario->tipo
                  ];
                  
                $payload =  AutentificadorJWT::CrearToken($datos);
            } else {
                $payload = json_encode(array("mensaje" => "No se pudo verirficar el usuario o la contraseña"));
            }
        }
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function VerificarUsuario(Request $request, Response $response)
    {

        if (empty($request->getHeaderLine('Authorization'))) {
            $payload = json_encode(array("mensaje" => "Falta Token de Autorizacion"));
        }
        else
        {
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            try{
                AutentificadorJWT::VerificarToken($token);
                $payload = json_encode(array("token" => AutentificadorJWT::ObtenerData($token)));
            }
            catch (Exception $ex)
            {
                $payload = json_encode(array('error'=> $ex->getMessage()));
            }
        }
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }
}
