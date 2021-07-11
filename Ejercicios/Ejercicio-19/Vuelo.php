<?php
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/
class Vuelo
{
    private $_fecha;
    private $_empresa;
    private $_precio;
    private $_listaDePasajeros;
    private $_cantMaxima;

    public function __construct(String $_empresa, float $_precio, int $_cantMaximaPasajeros=0)
    {
        $this->_fecha = new DateTime("now");
        $this->_empresa = $_empresa;
        $this->_precio = $_precio;
        $this->_cantMaxima = $_cantMaximaPasajeros;
        $this->_listaDePasajeros = array();
    }

    public function GetCantidadMaximaPasajeros()
    {
        return $this->_cantMaxima;
    }
    private function GetInfoVuelo()
    {
        $returnAux = "Fecha de Vuelo: " . date_format($this->_fecha,"d/M/Y") .
        "<br>Empresa: " . $this->_empresa . 
        "<br>Precio de Vuelo: " . $this->_precio . 
        "<br> Q Max Pasajeros: " . $this->_cantMaxima . 
        "<br><br>*****Pasajeros*****<br><br>";
        foreach ($this->_listaDePasajeros as $key => $pasajero) {
            $returnAux .= Pasajero::MostrarPasajero($pasajero);
        }
        return $returnAux;
    }

    public function Equals(Pasajero $pasajero)
    {
        $returnAux = false;
        if(!is_null($pasajero) && is_a($pasajero, "Pasajero") && in_array($pasajero, $this->_listaDePasajeros))
        {
            $returnAux = true;
        }
        return $returnAux;
    }

    public function AgregarPasajero(Pasajero $pasajero)
    {
        $returnAux =  false;
        if(!is_null($pasajero) && is_a($pasajero, "Pasajero") && !$this->Equals($pasajero) && $this->_cantMaxima > sizeof($this->_listaDePasajeros))
        {
            array_push($this->_listaDePasajeros, $pasajero);
            $returnAux = true;
        }

        return $returnAux;
    }
    public function MostrarVuelo ()
    {
        return $this->GetInfoVuelo();
    }

    public static function Add(Vuelo $v1, Vuelo $v2)
    {
        $returnAux = 0;
        if(!is_null($v1) && !is_null($v2) && is_a($v1,"Vuelo") && is_a($v2,"Vuelo"))
        {
            $cantPasajerosConDtoV1 = Vuelo::GetCantidadPasajerosPlus($v1->_listaDePasajeros);
            $cantPasajerosConDtoV2 = Vuelo::GetCantidadPasajerosPlus($v2->_listaDePasajeros);
            $cantPasajerosSinDtoV1 = sizeof($v1->_listaDePasajeros) - $cantPasajerosConDtoV1;
            $cantPasajerosSinDtoV2 = sizeof($v2->_listaDePasajeros) - $cantPasajerosConDtoV2;
            $recaudacionPasajerosConDto = (($cantPasajerosConDtoV1 * $v1->_precio) + ($cantPasajerosConDtoV2 * $v2->_precio)) * 0.8;
            $recaudacionSinDto = (($cantPasajerosSinDtoV1 * $v1->_precio) + ($cantPasajerosSinDtoV2 * $v2->_precio));
            $returnAux = $recaudacionPasajerosConDto + $recaudacionSinDto;
        }
        return $returnAux;
    }
    private static function GetCantidadPasajerosPlus($_listaDePasajeros)
    {
        $returnAux = 0;
        foreach ($_listaDePasajeros as $pasajero) {
            if(str_contains($pasajero->GetInfoPasajero(),"¿Es Plus?: SI"))
            {
                $returnAux++;
            }
        }
        return $returnAux;
    }

    public static function Remove(Vuelo $vuelo,Pasajero $pasajero)
    {
        if((!is_null($pasajero) && is_a($pasajero, "Pasajero") && !is_null($vuelo) && is_a($vuelo, "Vuelo")))
        {
            if($vuelo->Equals($pasajero))
            {
                unset($vuelo->_listaDePasajeros[array_search($pasajero,$vuelo->_listaDePasajeros)]);
            }
            else
            {
                echo "<br>El pasajero no se encuentra en este vuelo<br>";
            }
        }
        return $vuelo;
    }
}

?>