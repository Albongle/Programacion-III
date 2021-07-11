<?php
/******************************************************************************
Alumno : Alejandro Bongioanni
Aplicación Nº 14 (Par e impar)
Crear una función llamada esPar que reciba un valor entero como parámetro y devuelva T RUE
si este número es par ó F ALSE si es impar.
Reutilizando el código anterior, crear la función esImpar .


*******************************************************************************/

function esImpar ($numero)
{
    return !esPar($numero);
}

function esPar($numero)
{
    $returnAux = false;
    if (($numero%2) == 0)
    {
        $returnAux = true;
    }

    return $returnAux;
}

?>