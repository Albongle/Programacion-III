<?php
require_once 'usuario.php';
require_once 'IApiUsable.php';

class UsuarioApi extends Usuario implements IApiUsable
{
    public function TraerUno($request, $response, $args)
    {
        $id=$args['id'];
        $elUsuario=Usuario::TraerUnUsuario($id);
        $newResponse = $response->withJson($elUsuario, 200);
        return $newResponse;
    }
    public function TraerTodos($request, $response, $args)
    {
        $todosLosUsuarios=Usuario::TraerTodoLosUsuarios();
        $newResponse = $response->withJson($todosLosUsuarios, 200);
        return $newResponse;
    }
    public function CargarUno($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $nombre= $ArrayDeParametros['nombre'];
        $apellido= $ArrayDeParametros['apellido'];
        $mail= $ArrayDeParametros['mail'];
        $clave=$ArrayDeParametros['clave'];
        $localidad=$ArrayDeParametros['localidad'];

       
        $miUsuario = new Usuario();
        $miUsuario->nombre= $nombre;
        $miUsuario->apellido = $apellido;
        $miUsuario->mail = $mail;
        $miUsuario->clave = $clave;
        $miUsuario->localidad = $localidad;
        $miUsuario->InsertarElUsuarioParametros();

        //$archivos = $request->getUploadedFiles();
        //$destino="./fotos/";
        //var_dump($archivos);
        //var_dump($archivos['foto']);

        //$nombreAnterior=$archivos['foto']->getClientFilename();
        //$extension= explode(".", $nombreAnterior)  ;
        //var_dump($nombreAnterior);
        //$extension=array_reverse($extension);

        //$archivos['foto']->moveTo($destino.$titulo.".".$extension[0]);
        $response->getBody()->write("se guardo el Usuario");

        return $response;
    }
    public function BorrarUno($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $id=$ArrayDeParametros['id'];
        $miUsuario= new Usuario();
        $miUsuario->id=$id;
        $cantidadDeBorrados=$miUsuario->BorrarUsuario();
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->cantidad=$cantidadDeBorrados;
        if ($cantidadDeBorrados>0) {
            $objDelaRespuesta->resultado="algo borro!!!";
        } else {
            $objDelaRespuesta->resultado="no Borro nada!!!";
        }
        $newResponse = $response->withJson($objDelaRespuesta, 200);
        return $newResponse;
    }
    
    public function ModificarUno($request, $response, $args)
    {
        //$response->getBody()->write("<h1>Modificar  uno</h1>");
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $miUsuario = new Usuario();
        $miUsuario->id=$ArrayDeParametros['id'];
        $miUsuario->nombre=$ArrayDeParametros['nombre'];
        $miUsuario->apellido=$ArrayDeParametros['apellido'];
        $miUsuario->clave=$ArrayDeParametros['clave'];
        $miUsuario->mail=$ArrayDeParametros['mail'];
        $miUsuario->localidad=$ArrayDeParametros['localidad'];
        $resultado =$miUsuario->ModificarUsuarioParametros();
        $objDelaRespuesta= new stdclass();
        //var_dump($resultado);
        $objDelaRespuesta->resultado=$resultado;
        return $response->withJson($objDelaRespuesta, 200);
    }

    public function Loguin($request, $response, $args)
    {
        $returnAux = false;
        $ArrayDeParametros = $request->getParsedBody();
        $miUsuario = new Usuario();
        $miUsuario->clave=$ArrayDeParametros['clave'];
        $miUsuario->mail=$ArrayDeParametros['mail'];
        $usuariosBd=Usuario::TraerTodoLosUsuarios();
        $resultado=$miUsuario->BuscaUsuarioEnArray($usuariosBd);
        switch ($resultado) {
                case -1:
                    {
                        echo "Usuario no registrado\n>";
                        break;
                    }
                case 0:
                    {
                        echo "Error en los datos\n";
                        break;
                    }
                default:
                    {
                        echo "Usuario Verificado\n";
                        $returnAux = true;
                        break;
                    }
            }
        
        return $returnAux;
    }
}
