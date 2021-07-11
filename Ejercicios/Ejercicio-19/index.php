<?php
require_once "Pasajero.php";
require_once "Vuelo.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
Aplicación Nº 19 (Pasajero - Vuelo)
Dadas las siguientes clases:
Pasajero
Atributos privados : _apellido (string), _nombre (string), _dni (string), _esPlus (boolean)
Crear un constructor capaz de recibir los cuatro parámetros.
Crear el método de instancia “Equals” que permita comparar dos objetos Pasajero. Retornará
TRUE cuando los _dni sean iguales.
Agregar un método getter llamado G etInfoPasajero , que retornará una cadena de caracteres
con los atributos concatenados del objeto.
Agregar un método de clase llamado M ostrarPasajero que mostrará los atributos en la página.
Vuelo
Atributos privados : _fecha (DateTime), _empresa (string) _precio (double), _listaDePasajeros
(array de tipo Pasajero), _cantMaxima (int; con su getter). Tanto _listaDePasajero como
_cantMaxima sólo se inicializarán en el constructor.
Crear el constructor capaz de que de poder instanciar objetos pasándole como parámetros:
i. La empresa y el precio.
ii. La empresa, el precio y la cantidad máxima de pasajeros.
Agregar un método getter, que devuelva en una cadena de caracteres toda la información de
un vuelo: fecha, empresa, precio, cantidad máxima de pasajeros, y toda la información de
todos los pasajeros.
Crear un método de instancia llamado AgregarPasajero, en el caso que no exista en la lista,
se agregará (utilizar Equals). Además tener en cuenta la capacidad del vuelo. El valor de
retorno de este método indicará si se agregó o no.
Agregar un método de instancia llamado MostrarVuelo, que mostrará la información de un
vuelo.
Crear el método de clase “Add” para que permita sumar dos vuelos. El valor devuelto deberá
ser de tipo numérico, y representará el valor recaudado por los vuelos. Tener en cuenta que si
un pasajero es Plus , se le hará un descuento del 20% en el precio del vuelo.
Crear el método de clase “Remove” , que permite quitar un pasajero de un vuelo, siempre y
cuando el pasajero esté en dicho vuelo, caso contrario, informarlo. El método retornará un
objeto de tipo Vuelo.
*******************************************************************************/
$pasajero1 =  new Pasajero("Bongioanni","Alejandro", "11111111", false);
$pasajero2 =  new Pasajero("Bongioanni","Juan", "22222222", true);
$pasajero3 =  new Pasajero("Bongioanni","Pedro", "33333333", true);
$pasajero4 =  new Pasajero("Bongioanni","Roman", "4444444", false);
$pasajero5 =  new Pasajero("Bongioanni","Jose", "5555555", false);
$pasajero6 =  new Pasajero("Bongioanni","Facundo", "6666666", false);

$vuelo1 = new Vuelo("Aerolineas Arg",2000,5);
$vuelo2 = new Vuelo("Aerolineas Arg",1000,6);

$vuelo1->AgregarPasajero($pasajero1);
$vuelo1->AgregarPasajero($pasajero2);
$vuelo1->AgregarPasajero($pasajero3);
$vuelo1->AgregarPasajero($pasajero4);
$vuelo1->AgregarPasajero($pasajero5);

echo $vuelo->MostrarVuelo()."<br><br>La recaudacion es de los dos vuelos es: " .Vuelo::Add($vuelo, $vuelo2);



?>