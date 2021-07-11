<?php
require_once "Usuario.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
Aplicación Nº 22 ( Login)
Archivo: Login.php
método:POST
Recibe los datos del usuario(clave,mail )por POST ,
crear un objeto y utilizar sus métodos para poder verificar si es un usuario registrado,
Retorna un :
“Verificado” si el usuario existe y coincide la clave también.
“Error en los datos” si esta mal la clave.
“Usuario no registrado si no coincide el mail“
Hacer los métodos necesarios en la clase usuario
*******************************************************************************/
//$clave = $_POST['clave'];
//$mail = $_POST['mail'];


if(isset($_POST['mail']) && isset($_POST['clave']))
{
    $clave = $_POST['clave'];
    $mail = $_POST['mail'];
    $usuario= new Usuario("",$clave,$mail);

    $listadoUsuarios = Usuario::LeerArchivoCSV("registro.csv");
    //var_dump($listadoUsuarios);
    $resultado = $usuario->ValidarUsuario($listadoUsuarios);
    echo "Usuario Solicitado: ", $usuario->ToString()."\n";
    switch($resultado)
    {
        case -1:
            {
                echo "Usuario no registrado\n>";
                break;
            }
        case 0:
            {
                echo "Error en los datos\n";
                break;
            }
        default:
            {
                echo "Verificado\n";
                break;
            }
    }
    //var_dump($resultado);
    
}
else
{
    echo "Algun dato es invalido";
}


?>