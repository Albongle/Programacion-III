<?php
require_once "./data/AccesoDatos.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/

class Producto{

    private $nombre;
    private $tipo;
    private $cantidad;
    private $precio;
    private $id_autoincremental;
    private $codigo_de_barras;
    private $fecha_de_creacion;
    private $fecha_de_modificacion;
    private const RUTAID = "./Producto/ultimoidproductos.txt";


    public function __construct(){
        
       
    }
    
    public function SetDatos(string $codigo,string $nombre, string $tipo, int $stock, float $precio){
        
        $this->SetNombre($nombre);
        $this->SetTipo($tipo);
        $this->SetStock($stock);
        $this->SetPrecio($precio);
        $this->SetCodigoDeBarras($codigo);        
    }


    private function ValidaCodigoDeBarras(string $codigo){
    
        return (isset($codigo) && is_string($codigo)) && strlen($codigo) == 8 && preg_match("/[0-9]{8}/",$codigo);
    }

    public function GetId()
    {
        return $this->id_autoincremental;
    }
    public function SetId(int $id)
    {
        if(isset($id) && is_int($id)){
            $this->id_autoincremental = $id;
            self::EscribirUltimoID(self::RUTAID,$id);
        }else{
            echo "ID invalido\n";
        }
    }
    public function GetNombre()
    {
        return $this->nombre;
    }
    public function SetNombre(string $nombre)
    {
        if(isset($nombre) && is_string($nombre)){
            $this->nombre = $nombre;
        }else{
            echo "Nombre invalido\n";
        }
    }

    public function GetTipo()
    {
        return $this->tipo;
    }
    public function SetTipo(string $tipo)
    {
        if(isset($tipo) && is_string($tipo)){
            $this->tipo = $tipo;
        }else{
            echo "Tipo invalido\n";
        }
    }
    public function GetStock()
    {
        return $this->cantidad;
    }
    public function SetStock(int $cantidad)
    {
        if(isset($cantidad) && is_int($cantidad)){
            $this->cantidad = $cantidad;
        }else{
            echo "Stock invalido\n";
        }
    }
    public function GetPrecio()
    {
        return $this->precio;
    }
    public function SetPrecio(float $precio)
    {
        if(isset($precio) && is_float($precio)){
            $this->precio = $precio;
        }else{
            echo "Precio invalido\n";
        }
    }
    public function GetCodigoDeBarras()
    {
        return $this->codigo_de_barras;
    }
    public function SetCodigoDeBarras(string $codigo)
    {
        if($this->ValidaCodigoDeBarras($codigo)){
            $this->codigo_de_barras = $codigo;
        }
        else{
            echo "Codigo de barras invalido\n";
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
        if(isset ($ruta) && is_string($ruta) && isset($dato) && is_int($dato))
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
     * Metodo que recibe un array de objetos y genera un listado HTML realizando el ToString de este.
     * @$array es el array de datos a imprimir en formato tabla
     * @return devuelve una lista desordenada por patalla con todos los datos del Producto
     */
    public static function ListarProductos($array)
    {
        if(isset($array) && is_array($array))
        {
            echo"<ul>";
            foreach ($array as $value) {
                echo "<li>" . $value->MostrarDatos()."</li>";
            }
            echo"</ul>";
        }
    }
    /**
     * @return devuelve un array con todos los datos del objeto
     */
    private function GetObjeto()
    {
        return array("id"=>$this->GetId(),"codigo"=>$this->GetCodigoDeBarras(),"nombre"=>$this->GetNombre(),"tipo"=>$this->GetTipo(),"stock"=>$this->GetStock(),"precio"=>$this->GetPrecio());
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

    /**
     * Comprueba si un producto es igual a otro mediante su codigo de barras
     * @var $usuario Es el Producto a validar
     * @return devuelve false si el producto es distitnto, True de lo contrario
    */
    public function Equals($producto)
    {
        $returnAux = false;
        if(isset($producto) && is_a($producto,"Producto"))
        {
            if($producto->GetCodigoDeBarras() == $this->GetCodigoDeBarras())
            {
                $returnAux = true;
            }
        }
        return $returnAux;
    }
    public static function TraerTodoLosProductos()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select nombre,tipo,stock,precio,fecha_de_creacion,codigo_de_barras from producto");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS,'Producto');		
	}
    private static function AgregaProductoBD(Producto $producto)
	{
        $returnAux = false;
        if (isset($producto) && is_a($producto, "Producto")) {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO producto (codigo_de_barras,nombre,tipo,stock,precio,fecha_de_creacion)VALUES(:codigo,:nombre,:tipo,:stock,:precio,:fecha)");
            $consulta->bindValue(':codigo',$producto->GetCodigoDeBarras(), PDO::PARAM_INT);
            $consulta->bindValue(':nombre',$producto->GetNombre(), PDO::PARAM_STR);
            $consulta->bindValue(':tipo',$producto->GetTipo(), PDO::PARAM_STR);
            $consulta->bindValue(':stock',$producto->GetStock(), PDO::PARAM_INT);
            $consulta->bindValue(':precio',$producto->GetPrecio(),PDO::PARAM_INT);
            $consulta->bindValue(':fecha',date("Y-m-d"),PDO::PARAM_STR);
            $consulta->execute();
            $returnAux = $objetoAccesoDato->RetornarUltimoIdInsertado();
        }
        return $returnAux;		
	}
    private static function ActualizaStockBD(Producto $producto)
	{
        $returnAux = false;
        if (isset($producto) && is_a($producto, "Producto")) {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE producto SET stock = :stock, fecha_de_modificacion = :fecha WHERE codigo_de_barras = :codigo");
            $consulta->bindValue(':codigo',$producto->GetCodigoDeBarras(), PDO::PARAM_INT);
            $consulta->bindValue(':stock',$producto->GetStock(), PDO::PARAM_INT);
            $consulta->bindValue(':fecha',date("Y-m-d"),PDO::PARAM_STR);
            $consulta->execute();
            $returnAux = true;
        }
        return $returnAux;	
	}


    public static function ValidaProductoEnBD(Producto $producto)
    {
        $returnAux = false;
        if (isset($producto) && is_a($producto, "Producto")) {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("select * from producto where codigo_de_barras = :codigo ");
            $consulta->bindValue(':codigo',$producto->GetCodigoDeBarras(), PDO::PARAM_STR);
            $consulta->execute();
            $productoAux = $consulta->fetchObject('Producto');
            if($producto->Equals($productoAux)){
                $returnAux = true;
            }	
        }
        return $returnAux;
    }
   public static function AltaProductoBD(Producto $producto)
   {
        if(isset($producto) && is_a($producto,"Producto")){
        
            if(self::ValidaProductoEnBD($producto)){
                if(self::ActualizaStockBD($producto)){
                    echo "Se actualizo el stock ";
                }
            }
            else{
                $indice = self::AgregaProductoBD($producto);
                echo "Se agregro un producto en el indice ".$indice;
            }
        }
        else{
            echo "No se pudo hacer\n";
        }
   }
}


?>