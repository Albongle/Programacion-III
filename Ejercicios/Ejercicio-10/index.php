<?php
/******************************************************************************
Alumno : Alejandro Bongioanni

Aplicación Nº 10 (Arrays de Arrays)
Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
Arrays de Arrays.

*******************************************************************************/
$color = array("Rojo", "Azul", "Negro", "Violeta","Verde");
$precio = array(100,50,200,120,80);
$marca = array ("Bic","Generica", "Faber", "Otra");
$trazo = array ("Fino", "Grueso", "Mediano");

$lapiceras = array(array("Color"=>$color[rand(0,4)],"Precio"=>$precio[rand(0,4)],"Marca"=>$marca[rand(0,3)],"Trazo"=>$trazo[rand(0,2)]),array("Color"=>$color[rand(0,4)],"Precio"=>$precio[rand(0,4)],"Marca"=>$marca[rand(0,3)],"Trazo"=>$trazo[rand(0,2)]),array("Color"=>$color[rand(0,4)],"Precio"=>$precio[rand(0,4)],"Marca"=>$marca[rand(0,3)],"Trazo"=>$trazo[rand(0,2)]));

foreach ($lapiceras as $i=> $lapicera)
{
    echo "Lapicera ", ($i+1)," </br>";
    foreach($lapicera as $j=> $datos)
    {
        echo $j,": ", $datos,"\t";
    }
    echo "</br>";
}


?>