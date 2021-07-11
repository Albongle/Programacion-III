<?php
require_once "./Usuario/Usuario.php";
require_once "./Producto/Producto.php";
require_once "./data/AccesoDatos.php";
/******************************************************************************
Alumno : Alejandro Bongioanni
*******************************************************************************/
class Venta{

    private Usuario $usuario;
    private Producto $producto;
    private $cantidad;
    private $id_autoincremental;

    public function __construct()
    {

    }
    public function SetDatos(Usuario $usuario, Producto $producto, int $cantidad)
    {
        $this->usuario = $usuario;
        $this->producto = $producto;
        $this->cantidad = $cantidad;
    }

    public function GetId()
    {
        return $this->id_autoincremental;
    }
    public function SetId(int $id)
    {
        if(isset($id) && is_int($id)){
            $this->id_autoincremental = $id;
        }else{
            echo "ID invalido\n";
        }
    }

    public function GetUsuario()
    {
       return $this->usuario;
    }
    public function SetUsuario(Usuario $usuario)
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
    public function SetProducto(Producto $producto)
    {
       if(isset($producto) && is_a ($producto, "Producto")){
            $this->producto = $producto;
       }
       else{
           $this->producto = null;
       }
    }
    public function GetCantidad()
    {
        return $this->cantidad;
    }
    public function SetCantidad(int $cantidad)
    {
        if(isset($cantidad) && is_int($cantidad)){
            $this->cantidad = $cantidad;
        }else{
            echo "Cantidad invalida\n";
        }
    }
    private function GetObjeto()
    {
        return array("idproducto"=>$this->GetId(),"idUsuario"=>$this->GetUsuario()->GetId(),"codigoDeBarra"=>$this->GetProducto()->GetCodigoDeBarras());
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
    public static function NuevaVenta(int $codigoDeBarras, int $idUsuario, int $cantidad)
    {
        $returnAux = null;
        if(isset($codigoDeBarras) && is_int($codigoDeBarras) && isset($idUsuario) && is_int($idUsuario)&& isset($cantidad) && is_int($cantidad)){
            $usuario=Usuario::VerificaExisitenciaDeUsuarioBD($idUsuario); //valido el usuario
            if(is_a($usuario,"Usuario")){
                $producto = Producto::VerificaExisitenciaDeProductoBD($codigoDeBarras); //valido el producto
                if(!is_a($producto,"Producto")){
                    echo "Producto inexistente\n";
                }
                else if ($producto->GetStock() >= $cantidad){ //Valido si el producto tiene stock solicitado para la venta

                    $producto->SetStock(($producto->GetStock()-$cantidad)); //modifico el stock de la instancia del producto
                    $venta = new Venta(); // Genero un objeto de venta
                    $venta->SetDatos($usuario,$producto,$cantidad); //cargo los datos al objeto de venta
                    if(self::CargarVentaBD($venta)){
                        Producto::AltaProductoBD($producto);//actualizo el stock en la Bd de producto, luego de que cargo la venta en BD
                        echo "Venta Realizada\n";
                        $returnAux = $venta;
                    }
                    else{
                        echo "Hubo un error al cargar la venta en la BD\n";
                    }
                }
                else{
                    echo "Producto sin stock requerido, se cancelo la venta del producto\n";
                }
            }
            else{
                echo "Usuario inexistente\n";
            }
        }
        return $returnAux;
    }

    private static function CargarVentaBD(Venta $venta)
    {
        $returnAux = false;
        if(isset($venta) && is_a($venta,"Venta")){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO venta (id_producto,id_usuario,cantidad,fecha_de_venta)VALUES(:idProducto,:idUsuario,:cantidad,:fecha)");
            $consulta->bindValue(':idProducto',$venta->GetProducto()->GetId(), PDO::PARAM_INT);
            $consulta->bindValue(':idUsuario',$venta->GetUsuario()->GetId(), PDO::PARAM_INT);
            $consulta->bindValue(':cantidad',$venta->GetCantidad(), PDO::PARAM_INT);
            $consulta->bindValue(':fecha',date("Y-m-d"), PDO::PARAM_STR);
            $consulta->execute();
            $returnAux = $objetoAccesoDato->RetornarUltimoIdInsertado();
        }
        return $returnAux;
    }

    public static function ObtenerVentasPorCantidad (int $cantidadMinima, int $cantidadMaxima)
    {
        if(isset($cantidadMinima) && isset($cantidadMaxima) && is_int($cantidadMinima) && is_int($cantidadMaxima))
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("select * from venta where cantidad between :minimo and :maximo");
            $consulta->bindValue(":minimo", $cantidadMinima);
            $consulta->bindValue(":maximo", $cantidadMaxima);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);	
        }
    }
}


?>