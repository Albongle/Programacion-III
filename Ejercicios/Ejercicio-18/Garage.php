<?php
require "Auto.php";
class Garage{
    private $_razonSocial;
    private $_precioPorHora;
    private $_autos;

    public function __construct(String $razonSocial, float $precioPorHora=0)
    {
        $this->_razonSocial = $razonSocial;
        $this->_precioPorHora = $precioPorHora;
        $this->_autos =  array();
    }

    public function MostrarGarage()
    {
        $returnAux="Razon Social: " . $this->_razonSocial . 
        "<br>Precio por Hora: " . $this->_precioPorHora . 
        "<br><br>";
        foreach ($this->_autos as $auto) {
                $returnAux .= "<br><br>".Auto::MostrarAuto($auto) . "<br>";
        }
        return $returnAux;
    }

    public function Equals (Auto $auto)
    {
        $returnAux = false;
        if(!is_null($auto) && is_a($auto, "Auto") && in_array($auto,$this->_autos))
        {
            $returnAux = true;            
        }
        return $returnAux;
    }
    public function Add(Auto $auto)
    {
        if(!is_null($auto) && is_a($auto, "Auto"))
        {
            if(!$this->Equals($auto))
            {
                array_push($this->_autos,$auto);
            }
            else
            {
                echo "<br>---El Auto ya se encuentra en el garage---<br>";
            }
        }
    }
    public function Remove(Auto $auto)
    {
        if(!is_null($auto) && is_a($auto, "Auto"))
        {
            if($this->Equals($auto))
            {
                unset($this->_autos[array_search($auto,$this->_autos)]);
            }
            else
            {
                echo "<br>---El Auto no se encuentra en el garage---<br>";
            }
        }
    }
}


?>