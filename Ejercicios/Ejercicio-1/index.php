
<?php
/******************************************************************************
Alumno : Alejandro Bongioanni

Aplicación Nº 1 (Sumar números)
Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no
supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
se sumaron.

*******************************************************************************/
$sumador = 0;
$contador = 0;

while (($contador + $sumador) <= 1000) {
    $contador++;
    $sumador+=$contador;
    echo  "</br>", $contador;
}
echo "</br>La suma es $sumador";
echo "</br>Se sumaron $contador numeros";

?>