<?php
require_once "./models/usuario.php";
require_once "./interfaces/IApiUsable.php";
require_once "./models/AutentificadorJWT.php";
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use App\Models\Usuario as Usuario;
use AutentificadorJWT as AutentificadorJWT;

class UsuarioController implements IApiUsable
{


    public function CargarUno(Request $request, Response $response, $args)
    {
        $parametros = $request->getParsedBody();
        if (isset($parametros['mail']) && isset($parametros['clave']) && isset($parametros['tipo'])) {
            if (!Usuario::where('mail', '=', $parametros['mail'])->first()) {
                $usr = new Usuario();
                $usr->mail= $parametros['mail'];
                $usr->clave = $parametros['clave'];
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


    /**
     * Metodo que genera el token del usuario previa validacion en BD
     */
    public function Login(Request $request, Response $response,$args)
    {
        $parametros = $request->getParsedBody();
        if (isset($parametros['mail']) && isset($parametros['clave'])) {
            $usuario =  Usuario::Where('mail', '=', $parametros['mail'])->where('clave', '=', $parametros['clave'])->first();
            if ($usuario) {
                $datos = [
                    "Id" => $usuario->idusuario,
                    "mail" => $usuario->mail,
                    "tipo" => $usuario->tipo
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

    public function TraerTodos(Request $request, Response $response, $args)
    {
        $lista = Usuario::all();
        $payload = json_encode(array("listaUsuario" => $lista));
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }




}
