<?php
require "entidades.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
Aplicación Nº 11 (Potencias de números)
Mostrar por pantalla las primeras 4 potencias de los números del uno 1 al 4 (hacer una función
que las calcule invocando la función p ow ).


*******************************************************************************/
echo "<table>"; 
for ($i=0; $i < 4; $i++) {
    echo "<tr>"; 
    for ($j=1; $j < 5; $j++) { 
        echo "<td>", $j, " elevado a la ", $i, "= ", potencia($j,$i), "</td>";
    }
    echo "</tr>";
}
echo "</table>"; 



?>