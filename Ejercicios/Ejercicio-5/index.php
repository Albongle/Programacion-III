
<?php
/******************************************************************************
Alumno : Alejandro Bongioanni

Aplicación Nº 5 (Números en letras)
Realizar un programa que en base al valor numérico de una variable $ num , pueda mostrarse
por pantalla, el nombre del número que tenga dentro escrito con palabras, para los números
entre el 20 y el 60.
Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.

*******************************************************************************/
$unidad = rand(0, 9);
$decena = rand(0, 9);
$textUnidad;
$textDecena;

$num = $unidad + ($decena * 10);

if($num >= 20 && $num <=60)
{
    if($unidad == 0)
    {
        echo strDecena($decena);
    }else{
        echo strDecena($decena)," y ", strUnidad($unidad);
    }
    
}
else
{
    echo "Numero fuera del rango $num";
}





function strUnidad($valor)
{
    switch ($valor) {
        case 1:
        {
            return "Uno";
        }
        case 2:
        {
            return "Dos";
        }
        case 3:
        {
            return "Tres";
        }
        case 4:
        {
            return "Cuatro";
        }
        case 5:
        {
            return "Cinco";
        }
        case 6:
        {
            return "Seis";
        }
        case 7:
        {
            return "Siete";
        }
        case 8:
        {
            return "Ocho";
        }
        case 9:
        {
            return "Nueve";
        }
        default:
        {
            return "";
        }
    }
}
function strDecena($valor)
{
    switch ($valor) {
        case 1:
        {
            return "Diez";
        }
        case 2:
        {
            return "Veinte";
        }
        case 3:
        {
            return "Treinta";
        }
        case 4:
        {
            return "Cuarenta";
        }
        case 5:
        {
            return "Cincuenta";
        }
        case 6:
        {
            return "Sesenta";
        }
        case 7:
        {
            return "Setenta";
        }
        case 8:
        {
            return "Ochenta";
        }
        case 9:
        {
            return "Noventa";
        }
        default:
        {
            return "";
        }
    }
}
?>