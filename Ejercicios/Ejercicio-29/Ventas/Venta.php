<?php
require_once "./Usuario/Usuario.php";
require_once "./Producto/Producto.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/
class Venta{

    private Usuario $usuario;
    private Producto $producto;
    private static $rutaUsuariosJson = "./Usuario/usuarios.json";
    private static $rutaProductosJson = "./Producto/productos.json";
    private static $rutaId = "./Ventas/ultimoidventas.txt";
    private static $rutaVentasJson = "./Ventas/ventas.json";
    private $id;

    /*
    private function __construct($id,Usuario $usuario, Producto $producto)
    {
        $this->SetUsuario($usuario);
        $this->SetProducto($producto);
        $this->SetId($id);
    }*/
    private function __construct()
    {

    }

    public function GetId()
    {
        return $this->id;
    }
    public function SetId(int $id)
    {
        if(isset($id) && is_int($id)){
            $this->id = $id;
            self::EscribirUltimoID(self::$rutaId,$id);
        }else{
            echo "ID invalido\n";
        }
    }

    public function GetUsuario()
    {
       return $this->usuario;
    }
    private function SetUsuario(Usuario $usuario)
    {
       if(isset($usuario) && is_a ($usuario, "Usuario")){
            $this->usuario = $usuario;
       }
       else{
           $this->usuario = null;
       }
    }
    public function GetProducto()
    {
       return $this->producto;
    }
    private function SetProducto(Producto $producto)
    {
       if(isset($producto) && is_a ($producto, "Producto")){
            $this->producto = $producto;
       }
       else{
           $this->producto = null;
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
    public static function ListarVentas($array)
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
    private function GetObjeto()
    {
        return array("idproducto"=>$this->GetId(),"idUsuario"=>$this->GetUsuario()->GetId(),"codigoDeBarra"=>$this->GetProducto()->GetCodigoDeBarras());
    }
    /**
     * @return devuelve una cadena de texto con los datos del objetos separados por coma
     */
    public function ventaToCSV()
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
    public function ventaToJSON()
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
    private static function LeerArchivoCSV(string $ruta)
    {
        $returnArray = array();
        if(isset($ruta) && is_string($ruta))
        {
            if (($archivo=fopen($ruta, "r"))) 
            {
                while (($datos = fgetcsv($archivo))) 
                {
                    array_push($returnArray,new Venta($datos[0],$datos[1],$datos[2]));
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
                while (($datos = fgets($archivo))) 
                {
                    $datos=json_decode($datos);
                    $producto = new Venta($datos->id,$datos->usuario,$datos->producto);
                    array_push($returnArray,$producto);
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
    public static function GuardarArchivo($dato, $ruta, $modificador="a")
    {
        $returnAux=false;
        if(isset($dato) && isset($ruta) && isset($modificador) && is_string($dato) && is_string($dato) && is_string($modificador))
        {
            $archivo=fopen($ruta, $modificador);
            if(fwrite($archivo,$dato)>0)
            {
                echo "Se guardo el registro en el archivo\n";
                $returnAux=true;
            }
            else
            {
                echo "Algo salio mal al escribir en el archivo\n"; 
            }
            if(isset($archivo))
            {
                if(!fclose($archivo)){
                    echo "Algo salio mal al cerrar el archivo\n";
                }
            }
        }
        return $returnAux;
    }

    public static function NuevaVenta(int $codigoDeBarras, int $idUsuario)
    {
        $returnAux = null;
        if(isset($codigoDeBarras) && is_int($codigoDeBarras) && isset($idUsuario) && is_int($idUsuario)){
            $arrayUsuarios = Usuario::LeerArchivo(self::$rutaUsuariosJson);
            $usuario = Usuario::ValidaIdEnArray($idUsuario,$arrayUsuarios);
            $arrayProductos = Producto::LeerArchivo(self::$rutaProductosJson);
            $producto = Producto::ValidaCodigoEnArray($codigoDeBarras,$arrayProductos);

            if(is_a($usuario,"Usuario")){
                if(!is_a($producto,"Producto")){
                    echo "Producto inexistente\n";
                }
                else if ($producto->GetStock()>0){
                    $returnAux = new Venta((self::LeerUltimoID(self::$rutaId))+1,$usuario,$producto);
                    self::GuardarArchivo($returnAux->ventaToJSON(),self::$rutaVentasJson);
                    Producto::NuevoProducto($producto->GetCodigoDeBarras(),$producto->GetNombre(),$producto->GetTipo(),-1,$producto->GetPrecio()); //Bajo el stock
                    echo "producto Realizada\n";
                }
                else{
                    echo "Producto sin stock, se cancelo la producto\n";
                }
            }
            else{
                echo "Usuario inexistente\n";
            }
        }
        return $returnAux;
    }
    public static function TraerTodasLasVentas()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from venta");
			$consulta->execute();
			return $consulta->fetchAll(PDO::FETCH_CLASS,'Venta');		
	}
}


?>