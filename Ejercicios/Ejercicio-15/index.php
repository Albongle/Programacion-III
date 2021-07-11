<?php
require_once "Rectangulo.php";
require_once "Triangulo.php";
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


$rectangulo = new Rectangulo(5,20);
$rectangulo->SetColor("red");

echo $rectangulo->ToString();

$triangulo = new Triangulo(5,5);
$triangulo->SetColor("Blue");
echo $triangulo->ToString();

?>