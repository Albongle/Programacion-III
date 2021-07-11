<?php
require_once "Usuario.php";
/******************************************************************************
Alumno : Alejandro Bongioanni



ENVIO DE NUEVO YA QUE LO HICE UN POCO MAS GENERICO
*******************************************************************************/



if (isset($_POST['nombre']) && isset($_POST['mail']) && isset($_POST['clave']) && isset($_FILES['foto']))
{

    $nombre= $_POST['nombre'];
    $mail = $_POST['mail'];
    $clave = $_POST['clave'];

    $usuario =  new Usuario($nombre,$clave,$mail);
    $ubicacionFoto = ".\\Usuario\\Fotos\\". $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'],$ubicacionFoto);
    $usuario->SetFoto($ubicacionFoto);
    Usuario::GuardarArchivo($usuario->UsuarioToJSON(),"Usuarios.json");
    //Usuario::GuardarArchivo($usuario->UsuarioToCSV(),"Usuarios.csv");
    echo $usuario->ToString();

}




?>