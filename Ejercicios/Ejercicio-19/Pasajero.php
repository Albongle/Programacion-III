<?php
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/

/**
* @var $_apellido String
* @var $_nombre String
* @var $_dni String
* @var $_dni bool
*/
class Pasajero{
    private $_apellido;
    private $_nombre;
    private $_dni;
    private $_esPlus;

    public  function __construct(String $apellido, String $nombre, String $dni, bool $esPlus)
    {
        $this->_apellido = $apellido;
        $this->_nombre = $nombre;
        $this->_dni = $dni;
        $this->_esPlus = $esPlus;
    }

    public function Equals(Pasajero $pasajero)
    {
        $returnAux =  false;
        if(!is_null($pasajero) && is_a($pasajero, "Pasajero") && $this->_dni == $pasajero->_dni)
        {
            $returnAux = true;
        }
        return $returnAux;
    }
    public function GetInfoPasajero()
    {
        return "Nombre: " . $this->_nombre . 
        "<br>Apellido: " . $this->_apellido . 
        "<br>DNI: " . $this->_dni . 
        "<br>¿Es Plus?: ". ($this->_esPlus ? "SI<br>" : "NO<br>");
    }

    public static function MostrarPasajero (Pasajero $pasajero)
    {
        return $pasajero->GetInfoPasajero();
    }
}

?>