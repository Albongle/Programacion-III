<?php
require_once "./Ventas/Venta.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
Aplicación Nº 25 (RealizarVenta)
Archivo: RealizarVenta.php
método:POST
Recibe los datos del producto(código de barra), del usuario (el id )y la cantidad de ítems ,por
POST .
Verificar que el usuario y el producto exista y tenga stock.
crea un ID autoincremental(emulado, puede ser un random de 1 a 10.000).
carga los datos necesarios para guardar la venta en un nuevo renglón.
Retorna un :
“venta realizada”Se hizo una venta
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en las clases
*******************************************************************************/

if(isset($_POST['codigoDeBarras']) && isset($_POST['idUsuario']))
{
    $codigo=$_POST['codigoDeBarras'];
    $id=$_POST['idUsuario'];
    $venta = Venta::NuevaVenta($codigo,$id);
    if(isset($venta)){
        echo $venta->ToString();
    }

    
}


?>