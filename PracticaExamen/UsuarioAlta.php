<?php
require_once "./Clases/Usuario.php";

if(isset($_POST['mail']) && isset($_POST['clave']) && $_FILES['archivo']){

    $mail = $_POST['mail'];
    $clave = $_POST['clave'];
    $archivo = $_FILES['archivo'];
    $usuario =  new Usuario($mail,$clave);

    if(!Usuario::VerificarExistencia($usuario)){
        $usuario->GuardarArchivo();
        $ubicacionFoto = ".\\archivos\\Fotos\\".$usuario->GetMail().$_FILES['archivo']['name']; //establezco la ruta a donde voy a mover la foto
        move_uploaded_file($_FILES['archivo']['tmp_name'],$ubicacionFoto); //muevo la foto
    }
    else
    {
        echo "Usuario ya registrado";
    }
}
else
{
    echo "Error en los datos recibidos";
}

?>