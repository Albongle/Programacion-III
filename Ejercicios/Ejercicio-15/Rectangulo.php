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
class Rectangulo extends FiguraGeometrica
{
    private $_ladoUno;
    private $_ladoDos;

    public function __construct($l1,$l2)
    {
        parent :: __construct();
        $this->_ladoUno = $l1;
        $this->_ladoDos = $l2;
        $this->CalcularDatos();
    }
    protected function CalcularDatos()
    {
        $this->_perimetro = 2* ($this->_ladoUno + $this->_ladoDos);
        $this->_superficie = $this->_ladoUno * $this->_ladoDos;
    }
    public function Dibujar()
    {
        $dibujo="";
        for ($i=0; $i < $this->_ladoUno ; $i++){
           for ($j=0; $j <$this->_ladoDos; $j++){
                $dibujo .= "<font color=" . $this->_color .">*</font>";

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