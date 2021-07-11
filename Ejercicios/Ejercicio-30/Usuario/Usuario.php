<?php
require_once "./data/AccesoDatos.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/
class Usuario{

    private $nombre;
    private $apellido;
    private $clave;
    private $mail;
    private $foto;
    private $fechaRegistro;
    private int $id;
    private $localidad;
    private const RUTAID = "./Usuario/ultimoidusuarios.txt";

    public function __construct()
    {
        
    }

    public function GetNombre()
    {
        return $this->nombre;
    }
    public function SetNombre(string $nombre)
    {
        if(isset($nombre) && is_string($nombre) && preg_match("/^[A-Za-z]{3,20}\ ?+[A-Za-z]{0,20}$/",$nombre)){
            $this->nombre = $nombre;
        }
        else{
            echo "Nombre Invalido\n";
        }
    }
    public function GetApellido()
    {
        return $this->apellido;
    }
    public function SetApellido(string $apellido)
    {
        if(isset($apellido) && is_string($apellido) && preg_match("/^[A-Za-z]{3,20}\ ?+[A-Za-z]{0,20}$/",$apellido)){
            $this->apellido= $apellido;
        }
        else{
            echo "Apellido Invalido\n";
        }
    }
    public function GetClave()
    {
        return $this->clave;
    }
    public function SetClave(string $clave)
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
    public function SetMail(string $mail)
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
        if(isset($this->id)){
            return $this->id;
        }
        
    }
    public function SetId($id)
    {
        if(isset($id) && is_int($id)){
            $this->id = $id;
            self::EscribirUltimoID(self::RUTAID,$id);
        }else{
            echo "ID invalido\n";
        }
    }
    public function GetFoto()
    {
        return $this->foto;
    }
    public function SetFoto($foto)
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
    public function GetLocalidad()
    {
        return $this->localidad;
    }
    public function SetLocalidad($localidad)
    {
        if(isset($localidad) && is_string($localidad))
        {
            $this->localidad = $localidad;
        }
        else{
            echo "Localidad Invalida\n";
        }
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

     /**
     * @return devuelve un array con todos los datos del objeto
     */
    private function GetObjeto()
    {
        return array("id"=>$this->GetId(),"nombre"=>$this->GetNombre(),"apellido"=>$this->GetApellido(),"clave"=>$this->GetClave(),"mail"=>$this->GetMail(),"fechaRegistro"=>$this->GetFechaRegistro(),"foto"=>$this->GetFoto());
    }

    /**
     * @return devuelve todos los datos del Objeto en formato texto
     */
    public function MostrarDatos()
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

    public Function BuscaUsuarioEnArray($array)
    {
        $returnAux = -1;
        if(isset($array))
        {
            foreach ($array as $value) 
            {
                if(($returnAux = $this->ValidaUsuario($value)) == 1)
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
    public function ValidaUsuario(Usuario $usuario)
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
   
    
    public function InsertarElUsuarioParametros()
    {
           $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
           $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuario (nombre,apellido,clave,mail,fecha_de_registro,localidad)VALUES(:nombre,:apellido,:clave,:mail,:fecha_deregistro,:localidad)");
           $consulta->bindValue(':nombre',$this->GetNombre(), PDO::PARAM_STR);
           $consulta->bindValue(':apellido',$this->GetApellido(), PDO::PARAM_STR);
           $consulta->bindValue(':clave',$this->GetClave(), PDO::PARAM_STR);
           $consulta->bindValue(':mail',$this->GetMail(), PDO::PARAM_STR);
           $consulta->bindValue(':fecha_deregistro',$this->GetFechaRegistro(), PDO::PARAM_STR);
           $consulta->bindValue(':localidad',$this->GetLocalidad(), PDO::PARAM_STR);
           $consulta->execute();		
           return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public static function TraerTodoLosUsuarios()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select nombre,apellido,clave,mail from usuario");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS,'Usuario');		
	}

    public static function LoguinUsuario(Usuario $usuario)
	{
        if(isset($usuario) && is_a($usuario,"Usuario")){

            $usuariosBd=self::TraerTodoLosUsuarios();
            $resultado=$usuario->BuscaUsuarioEnArray($usuariosBd);
            switch($resultado)
            {
                case -1:
                    {
                        echo "Usuario no registrado\n>";
                        break;
                    }
                case 0:
                    {
                        echo "Error en los datos\n";
                        break;
                    }
                default:
                    {
                        echo "Verificado\n";
                        break;
                    }
            }
        }
	}
}

?>