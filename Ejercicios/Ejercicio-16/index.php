<?php
require_once "Rectangulo.php";
require_once "Punto.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
Aplicación Nº 16 (Rectangulo - Punto)
Codificar las clases Punto y Rectangulo.
La clase Punto ha de tener dos atributos privados con acceso de sólo lectura (sólo con
getters ), que serán las coordenadas del punto. Su constructor recibirá las coordenadas del
punto.
La clase Rectangulo tiene los atributos privados de tipo Punto _ vertice1 , _ vertice2 , _ vertice3
y _ vertice4 (que corresponden a los cuatro vértices del rectángulo).
La base de todos los rectángulos de esta clase será siempre horizontal. Por lo tanto, debe tener
un constructor para construir el rectángulo por medio de los vértices 1 y 3.
Los atributos l adoUno , l adoDos , á rea y p erímetro se deberán inicializar una vez construido el
rectángulo.
Desarrollar una aplicación que muestre todos los datos del rectángulo y lo dibuje en la página.

*******************************************************************************/
$rectangulo = new Rectangulo (new Punto(1,10), new Punto(25,0));

echo $rectangulo->Dibujar();


?>