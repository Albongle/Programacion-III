<?php
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/
class Usuario{

    private $nombre;
    private $clave;
    private $mail;
    public function __construct(string $nombre, string $clave, string $mail)
    {
        $this->nombre=$nombre;
        $this->clave=$clave;
        $this->mail=$mail;
    }
    public function GuardarCSV()
    {
        $returnAux=false;
        $archivo=fopen("registro.csv", "a");
        if(fwrite($archivo,$this->UsuarioToCSV())>0)
        {
            echo "Se guardo el registro";
            $returnAux=true;
        }
        else
        {
            echo "Algo salio mal al escribir"; 
        }
        if(isset($archivo))
        {
            if(!fclose($archivo)){
                echo "Algo salio mal al cerrar";
            }
        }
        return $returnAux;
    }

    public static function LeerArchivoCSV(string $ruta)
    {
        $cadena="";
        $returnArray = array();
        if(isset($ruta))
        {
            if (($archivo=fopen($ruta, "r"))) 
            {
                while (($datosUsuario = fgetcsv($archivo))) 
                {
                    array_push($returnArray,new Usuario($datosUsuario[0],$datosUsuario[1],$datosUsuario[2]));
                }
            }
        }
        return $returnArray;
    }
    public static function ListarUsuarios($array)
    {
        if(isset($array))
        {
            echo"<ul>";
            foreach ($array as $value) {
                echo "<li>" . $value->ToString()."</li>";
            }
            echo"</ul>";
        }
    }

    
    private function UsuarioToCsv()
    {
        return $this->nombre . "," .$this->clave. "," .$this->mail."\r\n";
    }
    public function ToString()
    {
        return "Nombre: " .$this->nombre . " Clave: " .$this->clave. " Mail: " .$this->mail;
    }


    /**
     * @var $array Es el array donde se va a verificar si existe el usuario de instancia
     * @return -1 si el mail no existe, 0 si no coincide la clave y 1 si esta OK
    */
    public Function ValidarUsuario($array)
    {
        $returnAux = -1;
        if(isset($array))
        {
            foreach ($array as $value) 
            {
                if(($returnAux = $this->Equals($value)) == 1)
                {
                    break;  
                }
            }
        }
        return $returnAux;
    }

    /**
     * @var $usuario Es el Usuatio a validar
     * @return -1 si el mail no existe, 0 si no coincide la clave y 1 si esta OK
    */
    public function Equals(Usuario $usuario)
    {
        $returnAux = -1;
        if(isset($usuario) && is_a($usuario,"Usuario"))
        {
            if($usuario->mail == $this->mail)
            {
                if($usuario->clave == $this->clave)
                {
                    $returnAux=1;
                }
                else
                {
                    $returnAux=0;
                }
            }
        }
        return $returnAux;
    }
}

?>