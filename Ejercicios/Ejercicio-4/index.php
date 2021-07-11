
<?php
/******************************************************************************
Alumno : Alejandro Bongioanni

Aplicación Nº 4 (Calculadora)
Escribir un programa que use la variable $ operador que pueda almacenar los símbolos
matemáticos: ‘ + ’, ‘ - ’, ‘ / ’ y ‘ * ’; y definir dos variables enteras $ op1 y $ op2 . De acuerdo al
símbolo que tenga la variable $operador, deberá realizarse la operación indicada y mostrarse el
resultado por pantalla.

*******************************************************************************/
$random = rand(1,4);
$op1 = rand(0,1000);
$op2 = rand(0,1000);
$resultado = 0;
switch ($random) {
    case 1:
        {
            $operador = "*";
            $resultado = $op1 * $op2;  
            break;
        }
    case 2:
        {
            $operador = "+";
            $resultado = $op1 + $op2;
            break;
        }
    case 3:
        {
            $resultado = $op1 - $op2;
            $operador = "-";
            break;
        }
    
    default:
        {
            $operador = "/";
            if($op2!=0)
            {
                $resultado = $op1 / $op2;
            }
            break;
        }
}

echo "El resultado de la operacion ", $op1, $operador , $op2, " es ", $resultado;


?>