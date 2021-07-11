<?php

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

abstract class FiguraGeometrica
{
    protected $_color;
    protected $_perimetro;
    protected $_superficie;

    public function __construct()
    {
        
    }

    public function GetColor()
    {
        return $this->_color;
    }
    public function SetColor($color)
    {
        $this->_color = $color;
    }

    public abstract function Dibujar();
    protected abstract function CalcularDatos();

    
    public function toString()
    {
        return "El perimetro es: ".  $this->_perimetro . "<br>" . "La Superficie es: ". $this->_superficie . "<br>" . "El Color es: " . $this->_color."<br>" ;
    }

}

?>