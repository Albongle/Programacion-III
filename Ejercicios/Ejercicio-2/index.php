
<?php
/******************************************************************************
Alumno : Alejandro Bongioanni

Aplicación Nº 2 (Mostrar fecha y estación)
Obtenga la fecha actual del servidor (función date ) y luego imprímala dentro de la página con
distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
año es. Utilizar una estructura selectiva múltiple.

*******************************************************************************/

echo "la fecha es:",  date("d/m/Y"),"</br>",date("D/M/Y"), "</br>";

switch(date("m"))
{
        case "12":
        case "01":
        case "02":
            {
                echo "Verano";
                break;
            }

        case "03":
        case "04":
        case "05":
            {
                echo "Otono";
                break;
            }

        case "06":
        case "07":
        case "08":
            {
                echo "Invierno";
                break;
            }

        default:
        {
            echo "Primavera";
            break;
        }
}

?>