<?php
require_once './models/pdf.php';
require_once './models/hortaliza.php';
require_once './models/ventaHortaliza.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Models\Hortaliza as Hortaliza;
use App\Models\VentaHortaliza as VentaHortaliza;


class InformeController
{
    public function DescargaPDF(Request $request, Response $response, array $args)
    {
        try {
            $id = $args['id'];
            $pdf = new PDF();
            $header = array('idHortaliza','fechaCreacion','precio','nombre','tipo', 'foto');
            $hortaliza = Hortaliza::where('idhortaliza','=', $id)->get();
            if ($hortaliza) {
                $pdf->AliasNbPages();
                $pdf->AddPage('L'); //pongo la pagina horizontal
                $pdf->SetFont('Times', '', 12);
                // hacer tabla,
                $hortaliza = $this->ToArray($hortaliza); // si no tengo fecha uso el metodo to Array de eloquent
   
                $pdf->FancyTable($header, $hortaliza); // tengo que enviar una array de los datos obtenidos de la base
                $pdf->Output();
  
                $payload = json_encode(array("Resultado" => "Descargado"));
                $response->getBody()->write($payload);

                return $response
                ->withHeader('Content-Type', 'application/pdf');
            } else {
            }
        } catch (Exception $ex) {
            $error = $ex->getMessage();
            $datosError = json_encode(array("Error" => $error));
            $response->getBody()->write($datosError);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    private function ToArray($datos)
    {
        $array =  array();
        foreach ($datos as $value) {
            $fechaCreacion = new DateTime($value->fechaCreacion);
            $array[] = [$value->idhortaliza,date_format($fechaCreacion,"d-M-Y"),$value->precio,$value->nombre,$value->tipo, $value->foto];
        }
            
            
        return $array;
    }

    public function VentasEmpleado(Request $request, Response $response, array $args)
    {
        $id = $args['id'];

        $ventas =  VentaHortaliza::where('idempleado','=', $id)->get();
        if(count($ventas)>0)
        {
            $payload = json_encode(array("Resultado" => $ventas));
        }
        else
        {
            $payload = json_encode(array("Resultado" => "No se econtraron ventas para dicho empleado"));
        }
        
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function HortalizaMasVendida(Request $request, Response $response, array $args)
    {

       
        $ventas =   Capsule::select('select Max(sumador.suma) as maximo, sumador.idhortaliza from
        (select sum(ventahortaliza.cantidad) as Suma, idhortaliza 
        FROM practicasegundoparcial.ventahortaliza 
        group by idhortaliza) as sumador');

        if(count($ventas)>0)
        {
            $payload = json_encode(array("Resultado" => $ventas,));
        }
        else
        {
            $payload = json_encode(array("Resultado" => "No se econtraron ventas para dicho empleado"));
        }
        
        $response->getBody()->write($payload);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    public function GenerarCSV(Request $request, Response $response, array $args)
    {

        $hortaliza =  Hortaliza::all()->toArray();
        $archivo=fopen("./archivo/informe.csv", "w");
        foreach ($hortaliza as $campos) {
            fputcsv($archivo, $campos);
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
        $payload = json_encode(array("Resultado" => "Se genero el archivo CSV"));
        $response->getBody()->write($payload);

        return $response
        ->withHeader('Content-Type', 'application/json');

    }


}
