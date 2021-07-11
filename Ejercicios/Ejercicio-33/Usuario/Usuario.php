<?php
require_once "./data/AccesoDatos.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/
class Usuario{

    private $nombre;
    private $apellido;
    private $claveNueva;
    private $mail;
    private $foto;
    private $fechaRegistro;
    private int $id_autoincrement;
    private $localidad;

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
    public function SetClave(string $claveNueva)
    {
        if(isset($claveNueva) && is_string($claveNueva)){
            $this->clave = $claveNueva;
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
        if(isset($this->id_autoincrement)){
            return $this->id_autoincrement;
        }
        
    }
    public function SetId($id)
    {
        if(isset($id) && is_int($id)){
            $this->id_autoincrement = $id;
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
                if(($returnAux = $this->ValidaUsuario($value)) != -1)
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
            if($usuario->GetMail() == $this->GetMail())
            {
                
                if($usuario->GetClave() == $this->GetClave())
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
           $consulta->bindValue(':fecha_deregistro',date("Y/m/d"), PDO::PARAM_STR);
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


    public static function VerificaExisitenciaDeUsuarioBD($idUsuario)
    {
        $returnAux=false;
        if(isset($idUsuario) && is_int($idUsuario)){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("select id_autoincrement, nombre,apellido,clave,mail from usuario where id_autoincrement = :id");
            $consulta->bindValue(':id',$idUsuario, PDO::PARAM_INT);
            $consulta->execute();
            $returnAux = $consulta->fetchObject('Usuario');
        }
        return $returnAux;
    }

    public static function LoguinUsuario(Usuario $usuario)
	{
        $returnAux = false;
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
                        echo "Usuario Verificado\n";
                        $returnAux = true;
                        break;
                    }
            }
        }
        return $returnAux;
	}
    public function ModificarPassword($claveNueva)
    {
        $returnAux=false;
        if(isset($claveNueva) && is_string($claveNueva)){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuario SET clave = :nuevaClave WHERE mail = :mail and clave = :viejaClave");
            $consulta->bindValue(':mail',$this->GetMail(), PDO::PARAM_STR);
            $consulta->bindValue(':viejaClave',$this->GetClave(), PDO::PARAM_STR);
            $consulta->bindValue(':nuevaClave',$claveNueva, PDO::PARAM_STR);
            $consulta->execute();
            $returnAux = true;
        }
        return $returnAux;
    }
}

?>