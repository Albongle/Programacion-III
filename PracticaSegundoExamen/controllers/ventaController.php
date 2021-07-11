<?php
require_once "./models/ventaHortaliza.php";
require_once "./models/hortaliza.php";
require_once "./interfaces/IApiUsable.php";
require_once "./models/AutentificadorJWT.php";

use App\Models\Hortaliza as Hortaliza;
use App\Models\VentaHortaliza as VentaHortaliza;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VentaController implements IApiUsable
{
    public function CargarUno(Request $request, Response $response, $args)
    {
        $parametros = $request->getParsedBody();
        $archivo = $request->getUploadedFiles();// levanto los archivos enviados
        if (isset($parametros['cantidad']) && isset($parametros['idhortaliza'])  && isset($archivo['foto']) && isset($parametros['nombrecliente'])) {
            try {
                $header = $request->getHeaderLine('Authorization'); //levanto el token de nuevo para tener los datos del cliente
                $token = trim(explode("Bearer", $header)[1]);
                $datos = AutentificadorJWT::ObtenerData($token);//datos cliente


                $nombreFoto = $archivo["foto"]->getClientFileName(); // obtengo el nombre de la foto
                $extension = explode(".", $nombreFoto);
                $extension = array_reverse($extension)[0]; //saco la extension
                if ($extension == "jpeg" || $extension == "png" || $extension == "jpg") {
                    $hortaliza =  Hortaliza::find($parametros['idhortaliza']);
                    if ($hortaliza) {
                        $destino="./img/FotosVentas/". $hortaliza->idhortaliza ."_". $parametros['nombrecliente'] .".".$extension; //pongo el destino de la foto con el nombre
                        $archivo['foto']->moveTo($destino); // muevo la foto al destino

                        $venta = new VentaHortaliza();
                        $venta->cantidad = $parametros['cantidad'];
                        $venta->idempleado = $datos->Id; // saco el ID del token
                        $venta->idhortaliza = $parametros['idhortaliza'];
                        $venta->foto =  $destino;
                        $venta->save();
                        $payload = json_encode(array("mensaje" => "Venta realizada con exito"));
                    } else {
                        $payload = json_encode(array("mensaje" => "hortaliza no disponible"));
                    }
                } else {
                    $payload = json_encode(array("mensaje" => "Formato de imagen no permitido"));
                }
            } catch (Exception $ex) {
                $payload = json_encode(array("mensaje" => $ex->getMessage()));
            }
        } else {
            $payload = json_encode(array("mensaje" => "No se recibio alguno de los parametros necesarios para la venta de la hortaliza"));
        }
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }
}
