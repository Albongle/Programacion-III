<?php
require_once "Operario.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/
/* @var $_operarios Operario*/
class Fabrica{
    private $_cantiMaxOperarios;
    private $_operarios;
    private $_razonSoncial;

    public function __construct(string $_razonSoncial, int $_cantiMaxOperarios = 0)
    {
        $this->_operarios = array();
        $this->_razonSoncial = $_razonSoncial;
        $this->_cantiMaxOperarios = $_cantiMaxOperarios;
    }
    private function RetornarCostos()
    {
        $returnAux = 0;
        foreach ($this->_operarios as $key => $operario) {
            $returnAux += $operario->GetSalario();
        }

        return $returnAux;
    }
    private function MostrarOperarios()
    {
        $returnAux = "";
        foreach ($this->_operarios as $key => $operario) {
            $returnAux .= $operario->Mostrar() . "<br>";
        }
        return $returnAux;
    }

    public static function MostrarCosto(Fabrica $fabrica = null)
    {
        if(!is_null($fabrica) && is_a($fabrica,"Fabrica"))
        {
            return $fabrica->RetornarCostos();
        }
    }

    public function Mostrar()
    {
        $returnAux ="Q MAX Empleados: " . $this->_cantiMaxOperarios . 
        "<br>Razon Social: " . $this->_razonSoncial . 
        "<br>Costo: " . Fabrica::MostrarCosto($this) . 
        "<br><br>---Operarios---<br><br>" . $this->MostrarOperarios();

        return $returnAux;
    }

    public static function Equals (Fabrica $fabrica = null, Operario $operario = null)
    {
        $returnAux = false;
        if((!is_null($fabrica) && is_a($fabrica,"Fabrica")) && (!is_null($operario) && is_a($operario,"Operario")))
        {
            if(in_array($operario,$fabrica->_operarios))
            {
                $returnAux = true;
            }
        }
        return $returnAux;
    }
    public function Add(Operario $operario = null)
    {
        $returnAux = false;
        if(!is_null($operario) && is_a($operario, "Operario"))
        {
            if(count($this->_operarios) < $this->_cantiMaxOperarios && !Fabrica::Equals($this, $operario))
            {
                array_push($this->_operarios, $operario);
                $returnAux = true;
            }
        }
        return $returnAux;
    }

    public function Remove(Operario $operario = null) 
    {
        $returnAux = false;
        if(!is_null($operario) && is_a($operario, "Operario"))
        {
            if(Fabrica::Equals($this,$operario))
            {
                unset($this->_operarios[array_search($operario,$this->_operarios)]);
                $returnAux = true;
            }
        }
        return $returnAux;
    }
}



?>