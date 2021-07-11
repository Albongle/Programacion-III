<?php
require_once "./Clases/Usuario.php";

if(isset($_GET['listado'])){
    $listado = $_GET['listado'];
}
else
{
    echo "Error en los datos recibidos";
}

?>