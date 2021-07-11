<?php


class Usuario
{
    public $nombre;
    public $apellido;
    public $clave;
    public $mail;
    public $fecha_de_registro;
    public $id;
    public $localidad;



    public function BorrarUsuario()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from usuario 				
				WHERE id=:id");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }

    public static function BorrarUsuarioPorMail($mail)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from usuario 				
				WHERE mail=:mail");
        $consulta->bindValue(':mail', $mail, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->rowCount();
    }
    public function ModificarUsuario()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("
				update usuario 
				set nombre='$this->nombre',
				apellido='$this->apellido',
				localidad='$this->localidad'
				WHERE id='$this->id'");
        return $consulta->execute();
    }
    
  
    public function InsertarElUsuario()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuario (nombre,apellido,clave,mail,fecha_de_registro,localidad)VALUES(:nombre,:apellido,:clave,:mail,:fecha_deregistro,:localidad)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_deregistro', date("Y/m/d"), PDO::PARAM_STR);
        $consulta->bindValue(':localidad', $this->localidad, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }

    public function ModificarUsuarioParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("
				update usuario 
				set nombre=:nombre,
				apellido=:apellido,
				clave=:clave,
                mail=:mail,
                localidad=:localidad
				WHERE id=:id");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':localidad', $this->localidad, PDO::PARAM_STR);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $consulta->execute();
    }

    public function InsertarElUsuarioParametros()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuario (nombre,apellido,clave,mail,fecha_de_registro,localidad)VALUES(:nombre,:apellido,:clave,:mail,:fecha_deregistro,:localidad)");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_deregistro', date("Y/m/d"), PDO::PARAM_STR);
        $consulta->bindValue(':localidad', $this->localidad, PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    public function GuardarUsuario()
    {
        if ($this->id>0) {
            $this->ModificarUsuarioParametros();
        } else {
            $this->InsertarElUsuarioParametros();
        }
    }


    public static function TraerTodoLosUsuarios()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
    }

    public static function TraerUnUsuario($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario where id =:id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        $cdBuscado= $consulta->fetchObject('Usuario');
        return $cdBuscado;
    }
    /*
    public static function TraerUnCdAnio($id, $anio)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select  titel as titulo, interpret as cantante,jahr as año from cds  WHERE id=? AND jahr=?");
        $consulta->execute(array($id, $anio));
        $cdBuscado= $consulta->fetchObject('cd');
        return $cdBuscado;
    }

    public static function TraerUnCdAnioParamNombre($id, $anio)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select  titel as titulo, interpret as cantante,jahr as año from cds  WHERE id=:id AND jahr=:anio");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':anio', $anio, PDO::PARAM_STR);
        $consulta->execute();
        $cdBuscado= $consulta->fetchObject('cd');
        return $cdBuscado;
    }

    public static function TraerUnCdAnioParamNombreArray($id, $anio)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("select  titel as titulo, interpret as cantante,jahr as año from cds  WHERE id=:id AND jahr=:anio");
        $consulta->execute(array(':id'=> $id,':anio'=> $anio));
        $consulta->execute();
        $cdBuscado= $consulta->fetchObject('cd');
        return $cdBuscado;
    }*/

    public function mostrarDatos()
    {
        return "Metodo mostar:".$this->nombre."  ".$this->apellido."  ".$this->mail."   ".$this->clave;
    }
}
?>