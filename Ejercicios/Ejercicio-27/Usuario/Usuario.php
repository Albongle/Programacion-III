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
    private static $rutaId = "./Usuario/ultimoidusuarios.txt";


    public function __construct(int $id,string $nombre, string $clave, string $mail, string $rutaFoto ="")
    {
        $this->SetNombre($nombre);
        $this->SetClave($clave);
        $this->SetMail($mail);
        $this->SetId($id);
        $this->SetFoto($rutaFoto);
        $this->fechaRegistro = date("d-M-Y");
    }

    public function GetNombre()
    {
        return $this->nombre;
    }
    private function SetNombre(string $nombre)
    {
        if(isset($nombre) && is_string($nombre) && preg_match("/^[A-Za-z]{3,20}\ ?+[A-Za-z]{0,20}$/",$nombre)){
            $this->nombre = $nombre;
        }
        else{
            echo "Nombre Invalido\n";
        }
    }
    public function GetClave()
    {
        return $this->clave;
    }
    private function SetClave(string $clave)
    {
        if(isset($clave) && is_string($clave)){
            $this->clave = $clave;
        }
        else{
            echo "Clave Invalido\n";
        }
    }
    public function GetMail()
    {
        return $this->mail;
    }
    private function SetMail(string $mail)
    {
        if(isset($mail) && is_string($mail)){
            $this->mail = $mail;
        }
        else{
            echo "Mail Invalido\n";
        }
    }
    
    public function GetId()
    {
        return $this->id;
    }
    private function SetId($id)
    {
        if(isset($id) && is_int($id)){
            $this->id = $id;
            self::EscribirUltimoID(self::$rutaId,$id);
        }else{
            echo "ID invalido\n";
        }
    }
    public function GetFoto()
    {
        return $this->foto;
    }
    private function SetFoto($foto)
    {
        if(isset($foto) && is_string($foto))
        {
            $this->foto = $foto;
        }
        else{
            echo "Foto Invalida\n";
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
                    array_push($returnArray,new Usuario($datosUsuario[0],$datosUsuario[1],$datosUsuario[2],$datosUsuario[3],$datosUsuario[4]));
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
                    $usuario = new Usuario($datosUsuario->id,$datosUsuario->nombre, $datosUsuario->clave,$datosUsuario->mail,$datosUsuario->foto);
                    $usuario->fechaRegistro = $datosUsuario->fechaRegistro;
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
     * Comprueba la existencia de un usuario dentro de un Array
     * @var $array Es el array donde se va a verificar si existe el usuario de instancia
     * @return devuelve -1 si el usuario no existe, la posicion del array de lo contrario
    */
    public Function ValidarUsuario($array)
    {
        $returnAux = -1;
        if(isset($array) && is_array($array))
        {
            foreach ($array as $key=> $value) 
            {
                if($this->Equals($value))
                {
                    $returnAux = $key;
                    break;  
                }
            }
        }
        return $returnAux;
    }

    /**
     * Compara dos usuarios mediante su ID
     * @var $usuario Es el Usuatio a validar
     * @return devuelve True si ambos ID coinciden, False de lo contrario
    */
    public function Equals(Usuario $usuario)
    {
        $returnAux = false;
        if(isset($usuario) && is_a($usuario,"Usuario"))
        {
            if($usuario->GetId() == $this->GetId())
            {
                $returnAux = true;
            }
        }
        return $returnAux;
    }
    /**
     * Comprueba si dentro de un array de usuarios se encuentra contenido el usuarios con un determinado ID
     * @var $idUsuario Es el Id a verificar
     * @var $arrayUsuarios Es el array de usuarios donde se va a buscar el ID
     * @return devuelve -1 si el ID no esta contenido, de lo contrario el Usuario en cuestion
     */
    public static function ValidaIdEnArray(int $idUsuario, $arrayUsuarios)
    {
        $returnAux = -1;
        if(isset($idUsuario) && is_int($idUsuario) && isset($arrayUsuarios) && is_array($arrayUsuarios)){
            foreach ($arrayUsuarios as $key => $value) {
                if($value->GetId()== $idUsuario){
                    $returnAux = new Usuario($value->GetId(),$value->GetNombre(),$value->GetClave(),$value->GetMail(),$value->GetFoto());
                    break;
                }
            }
        }
        return $returnAux;
    }

}

?>