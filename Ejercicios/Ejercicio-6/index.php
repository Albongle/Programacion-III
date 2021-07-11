
<?php
/******************************************************************************
Alumno : Alejandro Bongioanni

Aplicación Nº 6 (Carga aleatoria)
Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
función r and ). Mediante una estructura condicional, determinar si el promedio de los números
son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
resultado.

*******************************************************************************/
$vec = array(rand(0,9),rand(0,9),rand(0,9),rand(0,9),rand(0,9));
$suma=array_sum($vec);
$promedio = $suma / sizeof($vec);

if($promedio == (float)6)
{
    $resultado= "Igual";
}
elseif ($promedio < (float)6)
{
    $resultado= "Menor";
}
else
{
    $resultado= "Mayor";
}

echo "El resultado es ", $resultado, " 6";

?>