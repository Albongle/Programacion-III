<?php
/****Variables***
no se declara, se inicializa.
Ejemplo:
$variable=valor;
gettype(), devuelve el tipo de variable.
var_dump(), devuelve el tipo, los caracteres e imprime.
con comillas simples toma la varibale como texto puro.
para inicializar texto, mejor comillas simple.
\n : nueva linea
\r : retorno de carro
\t : tabulacion
\\ : barra invertida
\$ : signo de dolar
\" : comillas dobles
para concatenar se usa el . (punto)
para castear (int), (float)
print() imprime una cadena
printf(), se puede usar rara Vez
contantes  define("nombre", valor);
*********operadores aritmeticos = C
operador de exponente **
*********operadores de asignacion =C
*********operadores de comparacion**********
== (igualdad)
=== (igualdad del mismo tipo)
!= (distinto)
<> (distinto)
< (menor)
> (mayor)
<= (menor igual)
>= (mayor igual)
<=> (nave espacial) devueve -1,0,1 dependiendo la comparacion, menor, igual o mayor
? (ternario) es igual al If, pero resumido
?? (fusion null)
*********Comando de ejecucion***************
`dir`
isset($a), para evaluar si existe o no la variable
empty($a), para saber si esta vacia
is_integer($a), para validar si es entero
in_Array() para saber si un elemento esta dentro del array, devuelve bool
array_search() para buscar un elemento, devuelve el index
*********Manejo de sesion***************
session_start();
$_SESSION['nombreUsuario']="Roberto Gomez Bolaños";
$_SESSION['edad']=80;
con require(pagina.php) llamo a otras paginas o include, pero con include se sigue ejecutando lo de abajo
*/

$lapicera= new lapicera("Rojo","Bic","Gruezo", 110);

echo $lapicera->escribir();
echo $lapicera->getColor();




class lapicera{

    var $color;
    var $marca;
    var $trazo;
    var $precio;

    function __construct($color, $marca, $trazo, $precio)
    {
        $this->color = $color;
        $this->marca = $marca;
        $this->trazo = $trazo;
        $this->precio = $precio;
    }
    
    function escribir()
    {
        return "Escritura";
    }
    function getColor()
    {
        return $this->color;
    }
}
?>