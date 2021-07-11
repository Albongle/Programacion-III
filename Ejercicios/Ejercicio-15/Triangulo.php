<?php
require_once "FiguraGeometrica.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
La clase F iguraGeometrica posee: todos sus atributos protegidos, un constructor por defecto,
un método getter y setter para el atributo _ color , un método virtual (T oString ) y dos
métodos abstractos: D ibujar (público) y C alcularDatos (protegido).
CalcularDatos será invocado en el constructor de la clase derivada que corresponda, su
funcionalidad será la de inicializar los atributos _superficie y _perimetro.
Dibujar, retornará un string (con el color que corresponda) formando la figura geométrica del
objeto que lo invoque (retornar una serie de asteriscos que modele el objeto).
Ejemplo:
  *   *******
 ***  *******
***** *******
Utilizar el método ToString para obtener toda la información completa del objeto, y luego
dibujarlo por pantalla.

*******************************************************************************/
class Triangulo extends FiguraGeometrica
{
    private $_base;
    private $_altura;

    public function __construct($b,$h)
    {
        parent :: __construct();
        $this->_base= $b;
        $this->_altura = $h;
        $this->CalcularDatos();
    }
    protected function CalcularDatos()
    {
        $this->_perimetro = $this->_base + $this->_altura ;
        $this->_superficie = (float)(($this->_base * $this->_altura)/2) ;
    }
    public function Dibujar()
    {
        $dibujo="";
        for ($i=0; $i <$this->_altura  ;$i++) { 
            for ($j=0; $j <=$i*2; $j++){
                $dibujo .= "<font color=" . $this->_color. ">*</font>"; 
           }
           $dibujo .= "<br>";
        }
        return $dibujo;
    }
    public function ToString()
    {
        return parent::ToString()."<br>".$this->Dibujar();
    }
}

?>