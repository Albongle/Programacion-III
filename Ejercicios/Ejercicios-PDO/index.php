<?php
/**
    Alumno: Alejandro Bongioanni
 */
require_once "./consultasBD.php";

$listado = ConsultasBD::MostrarVentasPorFecha("2021-01-01","2021-01-31");

for ($i=0; $i < count($listado) ; $i++) { 
    foreach ($listado[$i] as $key => $value) {
        echo $key.": ". $value." ";
    }
    echo "<br>";
}



?>