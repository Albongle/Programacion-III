<?php
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/

class Operario{
    private $_apellido;
    private $_legajo;
    private $_nombre;
    private $_salario;


    public function __construct(int $_legajo, string $_apellido, string $_nombre)
    {
        $this->_legajo = $_legajo;
        $this->_apellido = $_apellido;
        $this->_nombre = $_nombre;
        $this->_salario = 1;
    }

    public function GetSalario()
    {
        return $this->_salario;
    }
    public function SetAumentarSalario(float $porcentaje = null)
    {
        if(!is_null($porcentaje) && is_numeric($porcentaje))
        {
            $this->_salario =$this->_salario + ($this->_salario * $porcentaje);
        }
    }
    public function GetNombreApellido ()
    {
        return $this->_nombre . ", " . $this->_apellido;
    }
    public function Mostrar()
    {
        return "Legajo: " . $this->_legajo .  
        "<br>Empleado: " . $this->GetNombreApellido() . 
        "<br>Salario: " . $this->_salario ."<br>";
    }
    
    public static function MostrarOperario (Operario $operario = null)
    {
        if(!is_null($operario) && is_a($operario, "Operario"))
        {
            return $operario->Mostrar();
        }
    }

    /**public static function __callStatic($name,$operario)
    {
        if($name == "Mostrar" && !is_null($operario) && is_a($operario, "Operario"))
        {
            return $operario->Mostrar();
        }
    }*/

    public function Equals (Operario $operario = null)
    {
        if(!is_null($operario) && is_a($operario, "Operario"))
        {
            return ($operario->_legajo == $this->_legajo) && ($operario->GetNombreApellido() == $this->GetNombreApellido());
        }
    }

}


?>