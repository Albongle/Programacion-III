<?php
require_once "Producto.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
Aplicación Nº 25 ( AltaProducto)
Archivo: altaProducto.php
método:POST
Recibe los datos del producto(código de barra (6 sifras ),nombre ,tipo, stock, precio )por POST
,
crea un ID autoincremental(emulado, puede ser un random de 1 a 10.000).
crear un objeto y utilizar sus métodos para poder verificar si es un producto existente,
si ya existe el producto se le suma el stock , de lo contrario se agrega al documento en un
nuevo renglón
Retorna un :
“Ingresado” si es un producto nuevo
“Actualizado” si ya existía y se actualiza el stock.
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en la clase usuario
*******************************************************************************/
if(isset($_POST['codigoDeBarra']) && isset($_POST['nombre']) && isset($_POST['tipo'])&& isset($_POST['stock'])&& isset($_POST['precio'])){
    $codigoDeBarra=$_POST['codigoDeBarra'];
    $nombre=$_POST['nombre'];
    $tipo=$_POST['tipo'];
    $stock=$_POST['stock'];
    $precio=$_POST['precio'];

    Producto::NuevoProducto($codigoDeBarra,$nombre,$tipo,$stock,$precio);
}
else
{
    echo "Aun no recibi nada";
}



?>