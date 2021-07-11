
<?php
/******************************************************************************
Alumno : Alejandro Bongioanni

Aplicación Nº 7 (Mostrar impares)
Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for ) cada uno en una línea distinta (recordar que el salto de línea en HTML es la etiqueta < br/> ). Repetir la impresión de los números utilizando
las estructuras while y foreach .

*******************************************************************************/
$vec = array();
$cont=0;
$num=0;
do{

    $resto = $num % 2;
    if($num != 0 && $resto != 0)
    {
        $vec[$cont] = $num;
        $cont ++;
    }
    $num++;

}while ($cont < 10);

echo "Impresion FOR </br>";

for ($i=0;$i < sizeof($vec); $i++){
    echo $vec[$i], "</br>";
}

echo "Impresion FOREACH </br>";
foreach ($vec as $i=> $valor )
{
    echo $valor, "</br>";
}
echo "Impresion WHILE </br>";
$i=0;
while ($i < sizeof($vec) )
{
    echo $vec[$i], "</br>";
    $i++;
}



?>