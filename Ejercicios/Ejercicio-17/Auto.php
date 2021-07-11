<?php
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/
class Auto{
    private String $_color;
    private Float $_precio;
    private String $_marca;
    private $_fecha;

    /**Constrctor Marca, Color, Precio y Fecha */
    public function __construct(String $marca, String $color,Float $precio = 0, $fecha = "01-01-1900")
    {
        $this->_marca = $marca;
        $this->_color = $color;
        $this->_precio = $precio;
        $this->_fecha=$fecha;
    }

    public function AgregarImpuestos($valor)
    {
        $this->_precio+= $valor;
    }
    public static function MostrarAuto(Auto $auto)
    {
        
        $returAux="";
        if(is_a($auto,"Auto"))
        {
            $strFecha=is_a($auto->_fecha,"DateTime") ? date_format($auto->_fecha,"d/m/Y") : $auto->_fecha;
            $returnAux = "Color: ". $auto->_color . 
            "<br>Marca: " . $auto->_marca . 
            "<br>Precio: " . $auto->_precio . 
            "<br>Fecha: " . $strFecha;
            
        }
        return $returnAux;
    }
    public function Equals(Auto $auto)
    {
        $returAux = false;
        if(is_a($auto,"Auto") && !is_null($auto) && $auto->_marca == $this->_marca)
        {
            $returAux = true;
        }
        return $returAux;
    }

    public static function Add(Auto $a1, Auto $a2)
    {
        $returnAux = 0;
        if($a1->Equals($a2) && $a1->_color == $a2->_color)
        {
            $returnAux = $a1->_precio + $a2->_precio;
        }
        else
        {
            echo "No se pudo realizar la operacion, se retorno: ";
        }
        return $returnAux;
    }


}


?>