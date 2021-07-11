<?php
require_once "./Ventas/Venta.php";

/**   
Aplicación Nº 31 (RealizarVenta BD )
Archivo: RealizarVenta.php
método:POST
Recibe los datos del producto(código de barra), del usuario (el id )y la cantidad de ítems ,por
POST .
Verificar que el usuario y el producto exista y tenga stock.
Retorna un :
“venta realizada”Se hizo una venta
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en las clases
 */

if (isset($_POST['codigoDeBarra']) && isset($_POST['idUsuario']) && isset($_POST['cantidad'])) {
    $codigoDeBarra = $_POST['codigoDeBarra'];
    $idUsuario = $_POST['idUsuario'];
    $cantidad = $_POST['cantidad'];
    $venta= Venta::NuevaVenta($codigoDeBarra, $idUsuario, $cantidad);
    if (isset($venta)) {
        $venta->MostrarDatos();
    }
}

?>