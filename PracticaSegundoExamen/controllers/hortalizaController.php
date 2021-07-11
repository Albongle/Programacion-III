<?php
require_once "./models/hortaliza.php";
require_once "./interfaces/IApiUsable.php";
require_once "./models/AutentificadorJWT.php";

use App\Models\Hortaliza as Hortaliza;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HortalizaController implements IApiUsable
{
    public function CargarUno(Request $request, Response $response, $args)
    {
        $parametros = $request->getParsedBody();
        $archivo = $request->getUploadedFiles();
        if (isset($parametros['precio']) && isset($parametros['nombre']) && isset($parametros['tipo']) && $archivo['foto']) {
            $nombreFoto = $archivo["foto"]->getClientFileName(); // obtengo el nombre de la foto
            $extension = explode(".", $nombreFoto);
            $extension = array_reverse($extension)[0]; //saco la extension
            if ($extension == "jpeg" || $extension == "png" || $extension == "jpg") {
                $hortaliza = new Hortaliza();
                $hortaliza->precio =  $parametros['precio'];
                $hortaliza->nombre =  $parametros['nombre'];
                $hortaliza->tipo = $parametros['tipo'];
                $destino="./img/hortalizas/".$nombreFoto; //pongo el destino de la foto
                $hortaliza->foto=$destino;
                $archivo['foto']->moveTo($destino); // muevo la foto al destino
                $hortaliza->save();
                $payload = json_encode(array("mensaje" => "hortaliza creado con exito"));
            } else {
                $payload = json_encode(array("mensaje" => "Formato de imagen no permitido"));
            }
        } else {
            $payload = json_encode(array("mensaje" => "No se recibio alguno de los parametros necesarios para el alta de hortaliza"));
        }
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');


    }

    
    public function TraerTodos(Request $request, Response $response, $args)
    {
        $lista = Hortaliza::all();
        $payload = json_encode(array("listaHortaliza" => $lista));
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

        
    public function TraerUno(Request $request, Response $response, $args)
    {
        if (isset($args['id'])) {
            $id=$args['id'];
            $hortaliza = Hortaliza::find($id);
            if ($hortaliza) {
                $payload = json_encode(array("hortaliza" => $hortaliza));
            } else {
                $payload = json_encode(array("mensaje"=>"No se econtro hortaliza con dicho ID"));
            }
        } else {
            $payload = json_encode(array("mensaje" => "No se recibidio algunos de los parametros necesarios"));
        }
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodoTipo(Request $request, Response $response, $args)
    {

        if(isset($args['tipo']))
        {
            $lista = Hortaliza::where('tipo','=',$args['tipo'])->get();
            $payload = json_encode(array("listaHortaliza" => $lista));
        }
        else
        {
            $payload = json_encode(array("mensaje" => "No se recibidio algunos de los parametros necesarios")); 
        }

        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno(Request $request, Response $response, $args)
    {
        if (isset($args['id'])) {
            $hortaliza =  Hortaliza::find($args['id']);
            if ($hortaliza) {
                Hortaliza::find($args['id'])->delete();
                $payload = json_encode(array("mensaje" => "hortaliza borrada con exito"));
            } else {
                $payload = json_encode(array("mensaje" => "hortaliza no encontrada"));
            }
        } else {
            $payload = json_encode(array("mensaje" => "No se recibidio algunos de los parametros necesarios para el borrado"));
        }

        $response->getBody()->write($payload);
        return $response;
    }

    public function ModificarUno(Request $request, Response $response, $args)
    {
        $parametros = $request->getParsedBody();
        $archivo =  $request->getUploadedFiles();

        $datos= self::ValidaCampos($parametros); //busco los campos a modificar, si me pasaron de mas a los seteados en Valida, no me importa
        if (isset($datos) && isset($archivo['foto']) && $args['id']) {
            $hortaliza =  Hortaliza::find($args['id']);
            if ($hortaliza) {
                foreach ($datos as $key => $value) {
                    $hortaliza->$key = $value;
                }
                $nombreFoto = $archivo['foto']->getClientFileName(); // obtengo el nombre de la foto
                $extension = explode(".", $nombreFoto);
                $extension = array_reverse($extension)[0]; //saco la extension
                $destino="./img/hortalizas/".$nombreFoto;
                if ($destino === $hortaliza->foto) {
                    $hortaliza->foto = $destino;
                    $destino="./img/Backup/".$nombreFoto;
                }
                $archivo['foto']->moveTo($destino);
                $hortaliza->save();
                $payload = json_encode(array("mensaje" => "Se modificaron los datos"));
            } else {
                $payload = json_encode(array("mensaje" => "No encontro ninguna hortaliza con dicho ID"));
            }           
        } else {
            $payload = json_encode(array("mensaje" => "No se recibidio algunos de los parametros necesarios"));
        }

        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    private static function ValidaCampos($array)
    {
        $datos =  array('nombre', 'precio', 'foto', 'tipo');
        $returnAux = null;

        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (in_array($key, $datos)) {
                    $returnAux[$key]=$array[$key];
                }
            }
        }
        return  $returnAux;
    }
}
?>