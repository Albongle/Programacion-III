<?php
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/
class Usuario{

    private $nombre;
    private $clave;
    private $mail;
    private $foto;
    private $fechaRegistro;
    private int $id;


    public function __construct(string $nombre, string $clave, string $mail)
    {
        $ruta = "ultimoId.txt";
        $this->nombre=$nombre;
        $this->clave=$clave;
        $this->mail=$mail;
        if(($idAux=self::LeerUltimoID($ruta))>=0)
        {
            $this->id = ($idAux + 1);
            self::EscribirUltimoID($ruta, $this->id);
        }
        $this->fechaRegistro = date("d-M-Y");
    }

    public function GetNombre()
    {
        return $this->nombre;
    }
    public function GetClave()
    {
        return $this->clave;
    }
    public function GetMail()
    {
        return $this->mail;
    }
    public function GetId()
    {
        return $this->id;
    }
    public function GetFoto()
    {
        return $this->foto;
    }
    public function SetFoto($foto)
    {
        if(isset($foto))
        {
            $this->foto = $foto;
        }
    }
    public function GetFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    private static function LeerUltimoID(string $ruta)
    {
        $returnAux=-1;
        if(isset($ruta) && is_string($ruta))
        {
            if (($archivo=fopen($ruta,"r"))) 
            {
                $returnAux=0;
                if(($dato = fread($archivo,1024))>=0)
                {
                    $returnAux = intval($dato);
                }                
            }
        }
        if(isset($archivo))
        {
            if(!fclose($archivo)){
                echo "Algo salio mal al cerrar\n";
            }
        }
        return $returnAux;
    }

    private static function EscribirUltimoID(string $ruta, int $dato)
    {
        $returnAux=false;
        if(isset ($ruta) && is_string($ruta) && isset($dato) && is_numeric($dato))
        {
            $archivo=fopen($ruta, "w");
            if(fwrite($archivo,$dato)>0)
            {
                echo "Se guardo el registro de ultimo ID\n";
                $returnAux=true;
            }
            else
            {
                echo "Algo salio mal al escribir ultimo ID\n"; 
            }
            if(isset($archivo))
            {
                if(!fclose($archivo)){
                    echo "Algo salio mal al cerrar registro ultimo ID\n";
                }
            }
            return $returnAux;
        }
    }
    public static function GuardarArchivo($dato, $ruta)
    {
        $returnAux=false;
        if(isset($dato) && isset($ruta)  && is_string($dato)  && is_string($dato))
        {
            $archivo=fopen($ruta, "a");
            if(fwrite($archivo,$dato)>0)
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

    private static function LeerArchivoCSV(string $ruta)
    {
        $returnArray = array();
        if(isset($ruta) && is_string($ruta))
        {
            if (($archivo=fopen($ruta, "r"))) 
            {
                while (($datosUsuario = fgetcsv($archivo))) 
                {
                    array_push($returnArray,new Usuario($datosUsuario[1],$datosUsuario[2],$datosUsuario[3]));
                }
            }
        }
        if(isset($archivo))
        {
            if(!fclose($archivo)){
                echo "Algo salio mal al cerrar CSV\n";
            }
        }
        return $returnArray;
    }
    private static function LeerArchivoJSON(string $ruta)
    {
        $returnArray=  array();
        if(isset($ruta) && is_string($ruta))
        {
            if (($archivo=fopen($ruta, "r"))) 
            {
                while (($datosUsuario = fgets($archivo))) 
                {
                    $datosUsuario=json_decode($datosUsuario);
                    $usuario = new Usuario($datosUsuario->nombre, $datosUsuario->clave,$datosUsuario->mail);
                    $usuario->SetFoto($datosUsuario->foto);
                    array_push($returnArray,$usuario);
                }
            }
            if(isset($archivo))
            {
                if(!fclose($archivo)){
                    echo "Algo salio mal al cerrar JSON\n";
                }
            }
        }
        return $returnArray;  
    }

    public static function LeerArchivo(string $ruta)
    {
        $returnArray = array();
        if(isset($ruta) && is_string($ruta))
        {
            $extension = pathinfo($ruta , PATHINFO_EXTENSION);
            
            switch(strtolower($extension))
            {
                case "csv":
                    {
                        $returnArray = self::LeerArchivoCSV($ruta); 
                        break;
                    }
                case "json":
                    {
                        $returnArray = self::LeerArchivoJSON($ruta); 
                        break;
                    }
                default:
                    {
                        echo "Extension no reconocida\n";
                        break;
                    }
            }
        }
        return $returnArray;
    }

    /**
     * Metodo que recibe un array de objetos y genera un listado HTML realizando el ToString de este.
     * @$array es el array de datos a imprimir en formato tabla
     * @return devuelve una lista desordenada por patalla con todos los datos del usuario 
     */
    public static function ListarUsuarios($array)
    {
        if(isset($array) && is_array($array))
        {
            echo"<ul>";
            foreach ($array as $value) {
                echo "<li>" . $value->ToString()."</li>";
            }
            echo"</ul>";
        }
    }
    /**
     * @return devuelve un array con todos los datos del objeto
     */
    private function GetObjeto()
    {
        return array("id"=>$this->GetId(),"nombre"=>$this->GetNombre(),"clave"=>$this->GetClave(),"mail"=>$this->GetMail(),"fechaRegistro"=>$this->GetFechaRegistro(),"foto"=>$this->GetFoto());
    }

    /**
     * @return devuelve una cadena de texto con los datos del objetos separados por coma
     */
    public function UsuarioToCSV()
    {
        $returnAux="";
        $flag = 0;
        foreach ($this->GetObjeto() as $key => $value) {
            $flag++;
            if($flag>1)
            {
                $returnAux.=",";
            }
            $returnAux.=$value;
        }
        $returnAux.="\r\n";
        return $returnAux;
    }
    /**
     * @return devuelve los datos del objeto en formato JSON
     */
    public function UsuarioToJSON()
    {
        if(isset($this))
        {
            return json_encode($this->GetObjeto())."\r\n";
        }
    }
    /**
     * @return devuelve todos los datos del Objeto en formato texto
     */
    public function ToString()
    {
        $returnAux="";
        $flag = 0;
        foreach ($this->GetObjeto() as $key => $value) {
            $flag++;
            if($flag>1)
            {
                $returnAux.=" ";
            }
            $returnAux.=$key . ": " . $value;
        }
        $returnAux.="\r\n";
        return $returnAux;
    }

    /**
     * @var $array Es el array donde se va a verificar si existe el usuario de instancia
     * @return devuelve -1 si el mail no existe, 0 si no coincide la clave y 1 si esta OK
    */
    public Function ValidarUsuario($array)
    {
        $returnAux = -1;
        if(isset($array) && is_array($array))
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
     * @return devuelve -1 si el mail no existe, 0 si no coincide la clave y 1 si esta OK
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