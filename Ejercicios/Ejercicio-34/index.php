<?php 

require_once "./Producto/Producto.php";
/**
Aplicación Nº 33 ( ModificacionProducto BD)
Archivo: modificacionproducto.php
método:POST
Recibe los datos del producto(código de barra (6 sifras ),nombre ,tipo, stock, precio )por POST
,
crear un objeto y utilizar sus métodos para poder verificar si es un producto existente,
si ya existe el producto el stock se sobrescribe y se cambian todos los datos excepto:
el código de barras .
Retorna un :
“Actualizado” si ya existía y se actualiza
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

    if(Producto::ValidaProductoEnBD($producto)){
        if(Producto::ActualizaStockBD($producto)){
            echo "Stock Actualizado";
        }
        else{
            echo "No se pudo actualizar el stock";
        }

    }
    else{
        echo "No esxite el producto en el BD\n";
    }
 
 
 }



?>