<?php
require_once "Usuario.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/
if(isset($_POST['nombre']) && isset($_POST['mail']) && isset($_POST['clave']))
{
    $nombre=$_POST['nombre'];
    $mail=$_POST['mail'];
    $clave=$_POST['clave']; 
    $usuario = new Usuario($nombre,$clave,$mail);
    $usuario->GuardarCSV();
}
else
{
    echo "Algun dato es invalido";
}


?>