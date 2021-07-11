<?php
/************************************************************
 * Alumno: Alejandro Bongioanni
 ************************************************************/
echo "va por GET<br>";
 var_dump($_GET);
echo "<br>va por POST<br>";
var_dump($_POST);

echo "<br>Bienvenido/a ", $_POST["nombre"];

?>