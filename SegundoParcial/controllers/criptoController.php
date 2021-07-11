<?php
require_once "./models/cripto.php";
require_once "./interfaces/IApiUsable.php";
require_once "./models/AutentificadorJWT.php";
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;



use App\Models\Cripto as Cripto;
use Illuminate\Support\Facades\Crypt;

class CriptoController implements IApiUsable
{
    public function CargarUno(Request $request, Response $response, $args)
    {
        $parametros = $request->getParsedBody(); //tengo que pasarle body porque desde el MDW retorno un request con array de datos $request->getParsedBody()['body'] si uso el otro metodo
        $archivo = $request->getUploadedFiles();// levanto los archivos enviados
        if (isset($parametros['precio']) && isset($parametros['nombre']) && isset($parametros['nacionalidad']) && $archivo['foto']) {
            $nombreFoto = $archivo["foto"]->getClientFileName(); // obtengo el nombre de la foto
            $extension = explode(".", $nombreFoto);
            $extension = array_reverse($extension)[0]; //saco la extension
            if ($extension == "jpeg" || $extension == "png" || $extension == "jpg") {
                $cripto = new Cripto();
                $cripto->precio =  $parametros['precio'];
                $cripto->nombre =  $parametros['nombre'];
                $cripto->nacionalidad = $parametros['nacionalidad'];
                $destino="./img/Criptos/".$nombreFoto; //pongo el destino de la foto
                $cripto->foto=$destino;
                $archivo['foto']->moveTo($destino); // muevo la foto al destino
                $cripto->save();
                $payload = json_encode(array("mensaje" => "Cripto creado con exito"));
            } else {
                $payload = json_encode(array("mensaje" => "Formato de imagen no permitido"));
            }
        } else {
            $payload = json_encode(array("mensaje" => "No se recibio alguno de los parametros necesarios para el alta de Cripto"));
        }
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno(Request $request, Response $response, $args)
    {
        $parametros = $request->getParsedBody();
        if (isset($parametros['id'])) {
            $cripto =  Cripto::find($parametros['id']);
            if ($cripto) {
                Cripto::find($parametros['id'])->delete();
                $payload = json_encode(array("mensaje" => "Cripto borrada con exito"));
            } else {
                $payload = json_encode(array("mensaje" => "Cripto no encontrada"));
            }
        } else {
            $payload = json_encode(array("mensaje" => "No se recibidio algunos de los parametros necesarios para el borrado"));
        }

        $response->getBody()->write($payload);
        return $response;
    }

    public function TraerTodos(Request $request, Response $response, $args)
    {
        $lista = Cripto::all();
        $payload = json_encode(array("listaCripto" => $lista));
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }
    
    public function TraerUno(Request $request, Response $response, $args)
    {
        if (isset($args['id'])) {
            $id=$args['id'];
            $cripto = Cripto::find($id);
            if ($cripto) {
                $payload = json_encode(array("Cripto" => $cripto));
            } else {
                $payload = json_encode(array("mensaje"=>"No se econtro cripto con dicho ID"));
            }
        } else {
            $payload = json_encode(array("mensaje" => "No se recibidio algunos de los parametros necesarios"));
        }
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno(Request $request, Response $response, $args)
    {
        $parametros = $request->getParsedBody();
        $archivo =  $request->getUploadedFiles();

        $datos= self::ValidaCampos($parametros); //busco los campos a modificar, si me pasaron de mas a los seteados en Valida, no me importa
        if (isset($datos) && isset($archivo['foto']) && $args['id']) {
            $cripto =  Cripto::find($args['id']);
            if ($cripto) {
                foreach ($datos as $key => $value) {
                    $cripto->$key = $value;
                }
                $nombreFoto = $archivo['foto']->getClientFileName(); // obtengo el nombre de la foto
                $extension = explode(".", $nombreFoto);
                $extension = array_reverse($extension)[0]; //saco la extension
                $destino="./img/Criptos/".$nombreFoto;
                if ($destino === $cripto->foto) {
                    $cripto->foto = $destino;
                    $destino="./img/Backup/".$nombreFoto;
                }
                $archivo['foto']->moveTo($destino);
                $cripto->save();
                $payload = json_encode(array("mensaje" => "Se modificaron los datos"));
            } else {
                $payload = json_encode(array("mensaje" => "No encontro ninguna cripto con dicho ID"));
            }           
        } else {
            $payload = json_encode(array("mensaje" => "No se recibidio algunos de los parametros necesarios"));
        }

        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    //valida campos para la modificacion y retorna un array con lo recibido posible de modficar
    private static function ValidaCampos($array)
    {
        $datos =  array('nombre', 'precio', 'foto', 'nacionalidad');
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

