<?php


class Usuario{
    private $email;
    private $clave;

    public function __construct($email,$clave)
    {
        $this->email = $email;
        $this->clave = $clave;
    }

    public function GetMail()
    {
        return $this->email;
    }
    /**
     * Funcion provada que convierte los datos de la clase en un array asocitivo, permitiendo usarlo con TXT, CSV y JSON
     */
    private function GetObjeto()
    {
        return array("mail"=>$this->email,"clave"=>$this->clave);
    }

    /**
     * Funcion que concatena los datos de la clase para enviar a un archivo con un delimitador
     */
    public function UsuarioToTXT()
    {
        $returnAux="";
        $flag = 0;
        foreach ($this->GetObjeto() as $key => $value) {
            $flag++;
            if($flag>1)
            {
                $returnAux.=" - ";
            }
            $returnAux.=$value;
        }
        $returnAux.="\r\n";
        return $returnAux;
    }
    /**
     * Funcion que convierte el objeto en tipo JSON
     */
    public function UsuarioToJSON()
    {
        if(isset($this))
        {
            return json_encode($this->GetObjeto())."\r\n";
        }
    }
    /**
     * Funcion para mostrar datos de la clase por pantalla, contatena la clave
     */
    public function ToString()
    {
        $returnAux="";
        $flag = 0;
        foreach ($this->GetObjeto() as $key => $value) {
            $flag++;
            if($flag>1)
            {
                $returnAux.=" - ";
            }
            $returnAux.=$key . ": " . $value;
        }
        $returnAux.="\r\n";
        return $returnAux;
    }
    /**
     * Funcion para guardar registros en un archivo
     */
    public function GuardarArchivo()
    {
        $returnAux=false;
        if(isset($this))
        {
            $archivo=fopen("./archivos/usuarios.txt", "a");
            if(fwrite($archivo,$this->UsuarioToTXT())>0)
            {
                echo "Se guardo el registro\n";
                $returnAux=true;
            }
            else
            {
                echo "Algo salio mal al escribir\n"; 
            }
            if(isset($archivo))
            {
                if(!fclose($archivo)){
                    echo "Algo salio mal al cerrar\n";
                }
            }
        }
        return $returnAux;
    }
    /**
     * funcion que lee todos los datos del archivo txt
     * 
     */
    public static function TraerTodos()
    {
        $returnArray = array();
        $ruta = "./archivos/usuarios.txt";
        if(isset($ruta) && is_string($ruta))
        {
            if (($archivo=fopen($ruta, "r"))) 
            {
                while (!feof($archivo)) 
                {
                    $archAux = fgets($archivo); //leo cada linea del archivo y retorno un string
                    $usuarios = explode("-", $archAux); //convierto en un array la linea leida, segun el delimitador
                    for ($i=0; $i < count($usuarios) ; $i++) //Elimino los espacios medios del array, esto solo hacerlo si entre el delimitador hay un espacio
                    { 
                        $usuarios[$i] = trim($usuarios[$i]);
                    }
                    if($usuarios[0] != ""){
                        $returnArray[] = new Usuario($usuarios[0], $usuarios[1]);
                    }
                }
            }
        }
        if(isset($archivo))
        {
            if(!fclose($archivo)){
                echo "Algo salio mal al cerrar archivo\n";
            }
        }
        return $returnArray;
    }

    /** Otra Manera
     * public static function TraerTodos()
    {
        $returnArray = array();
        $ruta = "./archivos/usuarios.txt";
        if(isset($ruta) && is_string($ruta))
        {
            if (($archivo=fopen($ruta, "r"))) 
            {
                while (($datosUsuario = fgetcsv($archivo,filesize($ruta),"-"))) 
                {
                    array_push($returnArray,new Usuario($datosUsuario[0],$datosUsuario[1]));
                }
            }
        }
        if(isset($archivo))
        {
            if(!fclose($archivo)){
                echo "Algo salio mal al cerrar archivo\n";
            }
        }
        return $returnArray;
    }
     */

    public function LeerArchivoJSON()
    {
        $returnArray=  array();
        $ruta = "./archivos/usuarios.json";
        if(isset($ruta) && is_string($ruta))
        {
            if (($archivo=fopen($ruta, "r"))) 
            {
                while (($datosUsuario = fgets($archivo))) 
                {
                    $datosUsuario=json_decode($datosUsuario);
                    $usuario = new Usuario($datosUsuario->mail,$datosUsuario->clave);
                    array_push($returnArray,$usuario);
                }
            }
            if(isset($archivo))
            {
                if(!fclose($archivo)){
                    echo "Algo salio mal al cerrar JSON";
                }
            }
        }
        return $returnArray;  
    }




    /**
     * Metodo de instancia que valida si 2 Usuarios son iguales
     *  
    */
    private function Equals (Usuario $usuario)
    {
        $returnAux = false;
        if (isset($usuario) && is_a($usuario, "Usuario")) {
            if($this->email == $usuario->email  && $this->clave == $usuario->clave){
                $returnAux = true;
            }
        }
        return $returnAux;
    }
    public static Function VerificarExistencia(Usuario $usuario)
    {
        $returnAux = false;
        if(isset($usuario) && is_a($usuario, "Usuario")){

            $listadoUsuarios = self::TraerTodos();
            foreach ($listadoUsuarios as $key => $value) {
                if($value->Equals($usuario)){
                    $returnAux = true;
                    break;
                }
            }
        }
        return $returnAux;

    } 
}
?>