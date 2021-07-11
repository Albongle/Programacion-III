<?php

require_once "Pizza.php";
const RUTAJSON = "./archivos/pizzas.json";

if(isset($_POST['sabor']) && isset($_POST['tipo'])){

    $sabor =$_POST['sabor'];
    $tipo = $_POST['tipo'];
    $pizza = new Pizza();
    $pizza->SetSabor($sabor);
    $pizza->SetTipo($tipo);

    $pizzas = Pizza::LeerArchivo(RUTAJSON);

    if(!$pizza->ValidarPizza($pizzas))
    {
        echo "No hay del sabor " . $sabor ;
    }
    else{
        echo "Si hay";
    }

}


?>