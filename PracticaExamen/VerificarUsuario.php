<?php
require_once "./Clases/Usuario.php";

if(isset($_POST['mail']) && isset($_POST['clave'])){

    $mail = $_POST['mail'];
    $clave = $_POST['clave'];
    $usuario =  new Usuario($mail,$clave);


    if(Usuario::VerificarExistencia($usuario)){

        $fecha =date("Y-m-d H:i:s");
        setcookie($mail,$fecha,time()+3600);
        //header("location:ListadoUsuario.php");
        echo "se creo cookie";
        
    }
    else
    {
        echo "Usuario no registrado";
    }
}
else
{
    echo "Error en los datos recibidos";
}

?>