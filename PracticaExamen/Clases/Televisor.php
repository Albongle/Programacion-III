<?php
require_once "./Clases/data/AccesoDatos.php";
require_once "./Clases/IParte2.php";
class Televisor implements IParte2 {
    public $tipo;
    public $precio;
    public $pais;
    public $foto;

    public function __construct()
    {

    }
    public function SetDatos($tipo,$precio,$pais,$foto)
    {
        if(isset($tipo) && isset($precio) && isset($pais)&& isset($foto))
        {
            $this->tipo =  $tipo;
            $this->precio = $precio;
            $this->pais =  $pais;
            $this->foto = $foto;
        }
    }

    public function Agregar()
    {
        $returnAux=false;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO televisores (tipo,precio,pais,foto) VALUES (:tipo,:precio,:pais,:foto)");
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':pais', $this->pais, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->execute();
        if($objetoAccesoDato->RetornarUltimoIdInsertado()>=0)
        {
            $returnAux = true;
        }
        return $returnAux;  
    }
    public static function Traer()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM televisores");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS,"Televisor");	
    }
    public function CalcularIVA()
    {
        return $this->precio + ($this->precio * 0.21);
    }
    public function Verificar($array)
    {
        $returnAux =  false;

        if(isset($array) && is_array($array)){
            
        }

        
    }
    public function ToString()
    {
        return $this->tipo." - ".$this->precio." - ".$this->pais." - ".$this->foto;
    }

}

?>