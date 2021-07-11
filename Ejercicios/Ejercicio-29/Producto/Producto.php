<?php
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/

class Producto{

    private $nombre;
    private $tipo;
    private $cantidad;
    private $precio;
    private $id;
    private $codigo;
    private static $rutaId = "./Producto/ultimoidproductos.txt";
    private static $rutaJson = "./Producto/productos.json";


    private function __construct(){
        
       
    }
    /*
    private function __construct(string $codigo,string $nombre, string $tipo, int $stock, float $precio){
        
        $this->SetNombre($nombre);
        $this->SetTipo($tipo);
        $this->SetStock($stock);
        $this->SetPrecio($precio);
        $this->SetCodigoDeBarras($codigo);        
    }*/


    private function ValidaCodigoDeBarras(string $codigo){
    
        return (isset($codigo) && is_string($codigo)) && strlen($codigo) == 6 && preg_match("/[0-9]{6}/",$codigo);
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
        return $this->codigo;
    }
    public function SetCodigoDeBarras(string $codigo)
    {
        if($this->ValidaCodigoDeBarras($codigo)){
            $this->codigo = $codigo;
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

    public static function NuevoProducto(string $codigo,string $nombre, string $tipo, int $stock, float $precio)
    {
        $productoAux= new Producto($codigo,$nombre,$tipo,$stock,$precio);        
        $arrayProdcutos = self::LeerArchivo(self::$rutaJson);
        $validacionProducto = $productoAux->ValidarProducto($arrayProdcutos);
        
        if($validacionProducto < 0)
        {
            $productoAux->SetId((self::LeerUltimoID(self::$rutaId) + 1));
            if(self::AgregarRegistros($productoAux,self::$rutaJson)){
                echo "Se agrego un nuevo Producto\n";
            }
            else{
                echo "No se pudo hacer nada";
            } 
        }
        else if($validacionProducto >= 0)
        {
            $stockAux=($arrayProdcutos[$validacionProducto]->GetStock() + $stock);
            $arrayProdcutos[$validacionProducto]->SetStock($stockAux);
            if(self::ModificarRegistros($arrayProdcutos,self::$rutaJson)){
                echo "Se actualizo el stock\n"; 
            }
            else{
                echo "No se pudo hacer nada";
            }               
        }
       
    }
    private static function AgregarRegistros($registro, $archivo)
    {
        $returnAux = false;
        if(isset($registro) && isset($archivo) && is_a($registro,"Producto") && is_string($archivo))
        {
            self::GuardarArchivo($registro->ProductoToJSON(),$archivo);
            $returnAux = true;
        }
        return $returnAux;
    }

    private static function ModificarRegistros($arrayRegistros, $archivo)
    {
        $returnAux = false;
        if(isset($arrayRegistros) && isset($archivo) && is_array($arrayRegistros) && is_string($archivo))
        {
            foreach ($arrayRegistros as $key => $value) {
                $key == 0 ? self::GuardarArchivo($value->ProductoToJSON(),$archivo,"w") : self::GuardarArchivo($value->ProductoToJSON(),$archivo);
            }
            $returnAux = true;
        }
        return $returnAux;
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
                echo "Algo salio mal al escribir en el archivo\\n"; 
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

    private static function LeerArchivoCSV(string $ruta)
    {
        $returnArray = array();
        if(isset($ruta) && is_string($ruta))
        {
            if (($archivo=fopen($ruta, "r"))) 
            {
                while (($datos = fgetcsv($archivo))) 
                {
                    array_push($returnArray,new Producto($datos[1],$datos[2],$datos[3],$datos[4],$datos[5]));
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
                    $producto = new Producto($datos->codigo,$datos->nombre,$datos->tipo,$datos->stock,$datos->precio);
                    $producto->SetId($datos->id);
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
        return array("id"=>$this->GetId(),"codigo"=>$this->GetCodigoDeBarras(),"nombre"=>$this->GetNombre(),"tipo"=>$this->GetTipo(),"stock"=>$this->GetStock(),"precio"=>$this->GetPrecio());
    }

    /**
     * @return devuelve una cadena de texto con los datos del objetos separados por coma
     */
    public function ProdcutoToCSV()
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
    public function ProductoToJSON()
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
     * Comprueba si un Producto existe dentro de un array
     * @var $array Es el array donde se va a verificar si existe el producto de instancia
     * @return devuelve La posicion del objeto en el Array, -1 si no fue encontrado
    */
    public Function ValidarProducto($array)
    {
        $returnAux =-1;
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
     * Comprueba si un producto es igual a otro mediante su codigo de barras
     * @var $usuario Es el Producto a validar
     * @return devuelve false si el producto es distitnto, True de lo contrario
    */
    public function Equals(Producto $producto)
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

        /**
     * Comprueba si dentro de un array de usuarios se encuentra contenido el usuarios con un determinado ID
     * @var $codigoDeBarras Es el Id a verificar
     * @var $arrayDeProductos Es el array de usuarios donde se va a buscar el ID
     * @return devuelve -1 si el ID no esta contenido, de lo contrario el Producto en cuestion
     */
    public static function ValidaCodigoEnArray(int $codigoDeBarras, $arrayDeProductos)
    {
        $returnAux = -1;
        if(isset($codigoDeBarras) && is_int($codigoDeBarras) && isset($arrayDeProductos) && is_array($arrayDeProductos)){
            foreach ($arrayDeProductos as $key => $value) {
                if($value->GetCodigoDeBarras()== $codigoDeBarras){
                    $returnAux = new Producto($value->GetCodigoDeBarras(),$value->GetNombre(),$value->GetTipo(),$value->GetStock(),$value->GetPrecio());
                    break;
                }
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
}


?>