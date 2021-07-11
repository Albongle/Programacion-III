<?php
require_once './models/pdf.php';
require_once './models/ventacripto.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as Capsule;

use App\Models\VentaCripto as VentaCripto;
use App\Models\Cripto as Cripto;
use App\Models\Usuario as Usuario;

class InformeController
{
    public function TodasLasVentas(Request $request, Response $response, array $args)
    {
        try {

            $pdf = new PDF();
            $header = array('idventacripto','fechaVenta','nacionalidad','mail','cantidad');
            $ventas = VentaCripto::join('cripto','cripto.idcripto','=','ventacripto.idcripto')->join('usuario','usuario.idusuario','=','ventacripto.idcliente')->select('ventacripto.idventacripto','ventacripto.fechaVenta','cripto.nacionalidad','usuario.mail','ventacripto.cantidad')->get();



            $pdf->AliasNbPages();
            $pdf->AddPage('L'); //pongo la pagina horizontal
            $pdf->SetFont('Times', '', 12);


            // hacer tabla, 
            $ventas = $this->ToArray($ventas); // si no tengo fecha uso el metodo to Array de eloquent
   
            $pdf->FancyTable($header,$ventas); // tengo que enviar una array de los datos obtenidos de la base
            $pdf->Output();
  
            $payload = json_encode(array("Resultado" => "Descargado"));
            $response->getBody()->write($payload);

            return $response
                ->withHeader('Content-Type', 'application/csv');
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $datosError = json_encode(array("Error" => $error));
            $response->getBody()->write($datosError);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }




    // la uso para pasar bien la fecha
    private function ToArray($datos)
    {
        $array =  array();
        foreach ($datos as $value) {
            $fecha =  new DateTime($value->fechaVenta);
            $array[] = [$value->idventacripto,date_format($fecha,"d-M-Y"),$value->nacionalidad,$value->mail,$value->cantidad];
        }
        
        
        return $array;
    }

    public function VentasMayorImporte(Request $request, Response $response, array $args)
    {
        try {

            $precioMax =  Cripto::all()->Max('precio');
            $idPrecioMax =  Cripto::where('precio','=',$precioMax)->get();
            $ventas = VentaCripto::join('cripto','cripto.idcripto','=','ventacripto.idcripto')->where('ventacripto.idcripto','=',$idPrecioMax[0]->idcripto)->join('usuario','usuario.idusuario','=','ventacripto.idcliente')->select('ventacripto.idventacripto','ventacripto.fechaVenta','cripto.nacionalidad','usuario.mail','ventacripto.cantidad')->get();
            $pdf = new PDF();
            $header = array('idventacripto','fechaVenta','nacionalidad','mail','cantidad');


            $pdf->AliasNbPages();
            $pdf->AddPage('L'); 
            $pdf->SetFont('Times', '', 12);

            $ventas = $this->ToArray($ventas);
   
            $pdf->FancyTable($header,$ventas); 
            $pdf->Output();
  
            $payload = json_encode(array("Resultado" => "Descargado"));
            $response->getBody()->write($payload);

            return $response
                ->withHeader('Content-Type', 'application/csv');
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $datosError = json_encode(array("Error" => $error));
            $response->getBody()->write($datosError);
            return $response->withHeader('Content-Type', 'application/json');
        }

        
    }


    public function MasTransacciones(Request $request, Response $response, array $args)
    {
        try {

            $header = array('idventacripto','fechaVenta','nacionalidad','mail','cantidad');
            $maxTrans = Capsule::select('select Max(trans.cantidad) as maxcantidad, trans.idcripto from
            (select idcripto, count(idventacripto) cantidad  from segundoparcial.ventacripto group by idcripto) as trans');

            $idCripto =  $maxTrans[0]->idcripto;


            $datosCripto =  Cripto::where('idcripto','=',$idCripto)->get();
            $pdf = new PDF();

            $pdf->AliasNbPages();
            $pdf->AddPage('L'); 
            $pdf->SetFont('Times', '', 12);
            
            foreach ($datosCripto as $cripto) {
                
                $pdf->Body($this->ToString($cripto));
            }
            $pdf->AddPage('L'); 
            $ventas =  VentaCripto::join('cripto','cripto.idcripto','=','ventacripto.idcripto')->where('ventacripto.idcripto','=',$idCripto)->join('usuario','usuario.idusuario','=','ventacripto.idcliente')->select('ventacripto.idventacripto','ventacripto.fechaVenta','cripto.nacionalidad','usuario.mail','ventacripto.cantidad')->get();
            $ventas = $this->ToArray($ventas); // si no tengo fecha uso el metodo to Array de eloquent
   
            $pdf->FancyTable($header,$ventas); // tengo que enviar una array de los datos obtenidos de la base

            $pdf->Output();
  
            $payload = json_encode(array("Resultado" => "Descargado"));
            $response->getBody()->write($payload);

            return $response
                ->withHeader('Content-Type', 'application/csv');
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $datosError = json_encode(array("Error" => $error));
            $response->getBody()->write($datosError);
            return $response->withHeader('Content-Type', 'application/json');
        }

        
    }

    private function ToString($dato)
    {
        $datos = "$dato->idcripto,$dato->precio, $dato->nombre, $dato->nacionalidad\n";
  
        return $datos;
    }

    public function GenerarCSV(Request $request, Response $response, array $args)
    {

        $tipo= $args['tipo'];
        if($tipo == "crito")
        {
            $datos = Cripto::all()->toArray();
            
            $archivo=fopen("./archivo/cripto.csv", "w");
            $payload = json_encode(array("Resultado" => "Se genero el archivo CSV de Cripto"));
        }
        else{
            $datos = Usuario::all()->toArray();
            $archivo=fopen("./archivo/usuario.csv", "w");
            $payload = json_encode(array("Resultado" => "Se genero el archivo usuario"));
        }
        foreach ($datos as $item) {
            fputcsv($archivo, $item);
        }
        if(isset($archivo))
        {
            if(!fclose($archivo)){
                $payload = json_encode(array("Resultado" => "Algo salio mal al cerrar el archivo"));
                $response->getBody()->write($payload);
                return $response
                ->withHeader('Content-Type', 'application/json');
            }
        }
        
        $response->getBody()->write($payload);

        return $response
        ->withHeader('Content-Type', 'application/json');

    }

}
