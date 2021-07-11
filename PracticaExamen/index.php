<?php
require_once "./Clases/Televisor.php";

$televisor =  new Televisor("LCD",1200,"Korea","./imagenes/imagen.jpg");


/*if($televisor->Agregar())
{
    echo "Se Agrego TV a la BD";
}*/
$cadena = 'apellido - email - teléfono';
$array = explode("-",$cadena);


$texto =trim($array[0]);
 var_dump($texto);


$televisores = $televisor->Traer();
echo $televisores[0]->ToString();

?>