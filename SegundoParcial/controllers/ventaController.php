<?php
require_once "./models/ventacripto.php";
require_once "./interfaces/IApiUsable.php";
require_once "./models/AutentificadorJWT.php";
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use AutentificadorJWT as AutentificadorJWT; //lo agreggo para poder sacar datos del JWT del cliente que voy a vender
use App\Models\VentaCripto as VentaCripto;
use App\Models\Cripto as Cripto;

class VentaController implements IApiUsable
{
    public function CargarUno(Request $request, Response $response, $args)
    {
        $parametros = $request->getParsedBody();
        $archivo = $request->getUploadedFiles();// levanto los archivos enviados
        if (isset($parametros['cantidad']) && isset($parametros['idcripto'])  && isset($archivo['foto'])) {
            try {
                $header = $request->getHeaderLine('Authorization'); //levanto el token de nuevo para tener los datos del cliente
                $token = trim(explode("Bearer", $header)[1]);
                $datos = AutentificadorJWT::ObtenerData($token);//datos cliente


                $nombreFoto = $archivo["foto"]->getClientFileName(); // obtengo el nombre de la foto
                $extension = explode(".", $nombreFoto);
                $extension = array_reverse($extension)[0]; //saco la extension
                if ($extension == "jpeg" || $extension == "png" || $extension == "jpg") {
                    $cripto =  Cripto::find($parametros['idcripto']);
                    if ($cripto) {
                        $destino="./img/FotosCripto/". $cripto->nombre ."_". explode('@',$datos->mail)[0] ."_". date("dMY").".".$extension; //pongo el destino de la foto con el nombre
                        $archivo['foto']->moveTo($destino); // muevo la foto al destino

                        $venta = new VentaCripto();
                        $venta->cantidad = $parametros['cantidad'];
                        $venta->idcliente = $datos->Id; // saco el ID del token
                        $venta->idcripto = $parametros['idcripto'];
                        $venta->save();
                        $payload = json_encode(array("mensaje" => "Venta realizada con exito"));
                    }
                    else
                    {
                        $payload = json_encode(array("mensaje" => "Cripto no disponible"));
                    }

  
                } else {
                    $payload = json_encode(array("mensaje" => "Formato de imagen no permitido"));
                }
            } catch (Exception $ex) {
                $payload = json_encode(array("mensaje" => $ex->getMessage()));
            }
        } else {
            $payload = json_encode(array("mensaje" => "No se recibio alguno de los parametros necesarios para la venta de la cripto"));
        }
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodosNacionalidad(Request $request, Response $response, $args)
    {
        $ventas =  VentaCripto::join('cripto','cripto.idcripto','=','ventacripto.idcripto')->join('usuario','usuario.idusuario','=','ventacripto.idcliente')->where('cripto.nacionalidad','=','Alemania')->where('ventacripto.fechaventa','>=','2021-05-01')->where('ventacripto.fechaventa','<=','2021-05-01')->select('ventacripto.idventacripto','ventacripto.fechaVenta','cripto.nacionalidad','usuario.mail','ventacripto.cantidad')->get();
        if(count($ventas)>0)
        {
            $payload = json_encode(array("mensaje" => $ventas));
        }
        else
        {
            $payload = json_encode(array("mensaje" => "No se encontraron ventas con los criterios establecidos"));
        }
        
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodosUsuariosVenta(Request $request, Response $response, $args)
    {
        if(isset($args['filtro']))
        {
            $filtro = $args['filtro'];
            $usuarios=  VentaCripto::join('cripto','cripto.idcripto','=','ventacripto.idcripto')->join('usuario','usuario.idusuario','=','ventacripto.idcliente')->where('cripto.nombre','=',$filtro)->select('usuario.idusuario', 'usuario.mail')->groupBy('usuario.idusuario','usuario.mail')->get();
            if(count($usuarios)>0)
            {
                $payload = json_encode(array("mensaje" => $usuarios));
            }
            else
            {
                $payload = json_encode(array("mensaje" => "No se encontraron usuarios con los criterios establecidos"));
            }
        }
        else
        {
            $payload = json_encode(array("mensaje" => "No se recibio algunos de los parametros requeridos"));
        }

        
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }
}
