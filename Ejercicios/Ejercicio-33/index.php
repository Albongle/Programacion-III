<?php 

require_once "./Usuario/Usuario.php";
/**
 * Aplicación Nº 32(Modificacion BD)
    Archivo: ModificacionUsuario.php
    método:POST
    Recibe los datos del usuario(nombre, clavenueva, clavevieja,mail )por POST ,
    crear un objeto y utilizar sus métodos para poder hacer la modificación,
    guardando los datos la base de datos
    retorna si se pudo agregar o no.
    Solo pueden cambiar la clave
 */

if(isset($_POST['nombre']) && isset($_POST['claveNueva']) && isset($_POST['claveVieja']) && isset($_POST['mail'])){

   $nombre = $_POST['nombre'];
   $claveNueva = $_POST['claveNueva'];
   $claveVieja = $_POST['claveVieja'];
   $mail = $_POST['mail'];

   $usuario = new Usuario();
   $usuario->SetNombre($nombre);
   $usuario->SetClave($claveVieja);
   $usuario->SetMail($mail);

   if(Usuario::LoguinUsuario($usuario)){
      if($usuario->ModificarPassword($claveNueva)){
         echo "Se actualizo el password\n";
      }
   }

}



?>