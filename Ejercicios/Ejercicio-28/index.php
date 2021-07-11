<?php
require_once "./Usuario/Usuario.php";

/**   
 * Aplicación Nº 27 (Registro BD) 
    Archivo: registro.php
    método:POST
    Recibe los datos del usuario(nombre, clave,mail )por POST , 
    crear un objeto y utilizar sus métodos para poder hacer el alta,
    guardando los datos  la base de datos 
    retorna si se pudo agregar o no.
 */

if(isset($_POST['nombre']) && isset($_POST['apellido'])&& isset($_POST['clave'])&& isset($_POST['mail'])&& isset($_POST['localidad'])){

   $nombre = $_POST['nombre'];
   $apellido = $_POST['apellido'];
   $clave = $_POST['clave'];
   $mail = $_POST['mail'];
   $localidad= $_POST['localidad'];

   $usuario =  new Usuario($nombre,$clave,$mail);
   $usuario->SetLocalidad($localidad);
   $usuario->SetApellido($apellido);

   echo $usuario->InsertarElUsuarioParametros();



}

?>