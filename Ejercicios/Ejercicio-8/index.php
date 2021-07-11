
<?php
/******************************************************************************
Alumno : Alejandro Bongioanni

Aplicación Nº 8 (Carga aleatoria)
Imprima los valores del vector asociativo siguiente usando la estructura de control f oreach :
$v[1]=90; $v[30]=7; $v['e']=99; $v['hola']= 'mundo';

*******************************************************************************/

$vec = array(1=>90,30=>7,'e'=>99, 'hola'=> 'mundo');
foreach($vec as $indice=> $valor)
{
    echo "En el indice ", $indice, " esta el valor ", $valor, "</br>";
} 

?>