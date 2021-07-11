<?php
require_once "./Producto/Producto.php";

/**   
Aplicación Nº 30 ( AltaProducto BD)
Archivo: altaProducto.php
método:POST
Recibe los datos del producto(código de barra (6 sifras ),nombre ,tipo, stock, precio )por POST
, carga la fecha de creación y crear un objeto ,se debe utilizar sus métodos para poder
verificar si es un producto existente,
si ya existe el producto se le suma el stock , de lo contrario se agrega .
Retorna un :
“Ingresado” si es un producto nuevo
“Actualizado” si ya existía y se actualiza el stock.
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en la clase
 */

if(isset($_POST['codigoDeBarra']) && isset($_POST['nombre']) && isset($_POST['tipo']) && isset($_POST['stock']) && isset($_POST['precio'])){


    $codigoDeBarra = $_POST['codigoDeBarra'];
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $stock= $_POST['stock'];
    $precio = $_POST['precio'];
 
    $producto =  new Producto();
    $producto->SetDatos($codigoDeBarra,$nombre,$tipo,$stock,$precio);

    Producto::AltaProductoBD($producto);
 
 
 }

?>