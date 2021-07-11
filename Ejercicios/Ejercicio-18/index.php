<?php
require_once "Garage.php";
require_once "Auto.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
Aplicación Nº 18 (Auto - Garage)
Crear la clase Garage que posea como atributos privados:
_razonSocial (String)
_precioPorHora (Double)
_autos (Autos[], reutilizar la clase Auto del ejercicio anterior)
Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:
i. La razón social.
ii. La razón social, y el precio por hora.
Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y
que mostrará todos los atributos del objeto.
Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
objeto de tipo Auto. Sólo devolverá T RUE si el auto está en el garaje.
Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage”
(sólo si el auto no está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Add($autoUno);
Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Remove($autoUno);
En t estGarage.php , crear autos y un garage. Probar el buen funcionamiento de todos los
métodos.
*******************************************************************************/
$miGarage = new Garage("Estacionamiento 24 Hs", 200);

$autos = array (new Auto("Ford","Rojo"), 
new Auto("Fiat","Azul"),
new Auto("Ford","Rojo"),
new Auto("Renault","Gris"),
new Auto("Chevrolet","Negro"));

foreach ($autos as $key => $auto) {
    $miGarage->Add($auto);
}

echo "<br><br>***Imprimo Garage con los autos que se pudieron agregar***<br><br>" . $miGarage->MostrarGarage();

$miGarage->Remove($autos[4]);

echo "<br><br>***Remuevo un auto e imprimo***<br><br>" . $miGarage->MostrarGarage();

?>