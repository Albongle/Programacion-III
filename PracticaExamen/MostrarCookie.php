<?php

if(isset($_GET['mail'])){
    $mail = $_GET['mail'];
    if(isset($_COOKIE))
    {
        foreach ($_COOKIE as $key => $value) {
            var_dump($key);
            var_dump($mail);
            var_dump($value);
            if(strcmp($key,$mail)==0)
            {
                echo "El valor de la Cookie ". $key ."es [".$value."]";
            }
        }
    }
    else{

    }
}


?>