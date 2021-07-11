<?php

/**
 * 
 * Alejandro Bongioanni Alta Venta
 */

require_once "Pizza.php";
require_once "Venta.php";


if(isset($_POST['mail']) && isset($_POST['sabor']) && isset($_POST['tipo']) && isset($_POST['cantidad']) && isset($_FILES['archivo'])){

    $sabor =$_POST['sabor'];
    $tipo = $_POST['tipo'];
    $cantidad = $_POST['cantidad'];
    $archivo = $_FILES['archivo'];
    $mail = $_POST['mail'];
    $pizza =  new Pizza();
    $pizza->SetSabor($sabor);
    $pizza->SetTipo($tipo);


    $pizzas = Pizza::LeerArchivo(Pizza::RUTAJSON);
    $pos=$pizza->ValidarPizza($pizzas);
    if($pos ==-1)
    {
        echo "No hay del sabor\n" . $sabor ;
    }
    else{
        echo "Si hay\n";
        if($pizzas[$pos]->GetCantidad()>$cantidad){
            $pedido =  rand(0,1000);
            $cadena  = explode("@",$mail);
            $cantidadDescontar = 0-$cantidad;
            Pizza::NuevaPizza($sabor, $pizzas[$pos]->GetPrecio(), $tipo,$cantidadDescontar);
            Venta::AltaVentaBD($mail,$pedido,$sabor,$tipo,$cantidad );
            $ubicacionFoto = ".\\archivos\\ImagenesDeLaVenta\\".$tipo.$sabor.$cadena[0].$_FILES['archivo']['name']; //establezco la ruta a donde voy a mover la foto
            move_uploaded_file($_FILES['archivo']['tmp_name'],$ubicacionFoto); //muevo la foto
        }
        else{
            echo "La demanda supera el stock\n";
        }

    }


}


?>