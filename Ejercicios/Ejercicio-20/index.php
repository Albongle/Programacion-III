<?php
require_once "Operario.php";
require_once "Fabrica.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/
$nombres = array("Jose", "Pedro","Alejandro", "Ramon", "Juan", "Sergio", "Ramiro");
$apellidos = array("Gonzalez", "Lopez","Suarez", "Fernandez", "Ramirez", "Garcia", "Martinez");
define("Q_EMP",10);
$fabrica = new Fabrica("COTO",Q_EMP);

for ($i = 0; $i < Q_EMP; $i++ ) { 
    $operario = new Operario($i,$apellidos[rand(0,6)], $nombres[rand(0,6)]);
    $operario->SetAumentarSalario((float)rand(20000,30000));
    $fabrica->Add($operario);
}


echo $fabrica->Mostrar();



?>