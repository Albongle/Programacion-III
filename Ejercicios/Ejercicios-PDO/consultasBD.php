<?php
/**
 *  Alumno: Alejandro Bongioanni
 * Funciones de filtrado:
    se deben realizar la funciones que reciban datos por parámetros y puedan
    ejecutar la consulta para responder a los siguientes requerimientos
 * 
 */
require_once "./data/AccesoDatos.php";
class ConsultasBD{    

    /** Ejecicio A
     * Funcion encargada de obtener todos los usuarios desde la BD y retorna un Array ordenado
     * @var $orden establecera como se quieren ordenar los usuarios, por defecto sera Ascendente, en caso de queres ordenar de forma Descendente se debera indicar "Desc"
     * @return devuelve un array con los usuarios ordenados
     */
    public static function ObtenerUsuariosOrdenados(string $orden="ASC")
	{
        if (isset($orden) && is_string($orden)) {
            if ($orden != "ASC" && $orden != "DESC") {
                $orden = "ASC";
            }
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuario ORDER BY nombre " .$orden);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        }
    }
	 /** Ejecicio B
     * Funcion encargada de obtener todos los productos desde la BD y retorna un Array ordenado
     * @var $orden establecera como se quieren ordenar los productos, por defecto sera Ascendente, en caso de queres ordenar de forma Descendente se debera indicar "Desc"
     * @return devuelve un array con los productos ordenados
     */
    public static function ObtenerProdcutosOrdenados(string $orden="ASC")
	{
        if(isset($orden) && is_string($orden))
        {
            if($orden != "ASC" && $orden != "DESC")
            {
                $orden = "ASC";
            }
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM producto ORDER BY nombre " .$orden);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);	
        }

    }
    /** Ejecicio C
     * Funcion encargada de obtener un listados de ventas segun su cantidad vendida
     * @var $cantidadMinima es la cantidad minima de elementos vendidos a consultar
     * @var $cantidadMaxima es la cantidad maxima de elementos vendidos a consultar
     * @return Array de Objetos obtenidos
     */
    public static function ObtenerVentasPorCantidad (int $cantidadMinima, int $cantidadMaxima)
    {
        if(isset($cantidadMinima) && isset($cantidadMaxima) && is_int($cantidadMinima) && is_int($cantidadMaxima))
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM venta WHERE cantidad BETWEEN :minimo AND :maximo");
            $consulta->bindValue(":minimo", $cantidadMinima);
            $consulta->bindValue(":maximo", $cantidadMaxima);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);	
        }
    }
    /** Ejecicio D
     * Funcion encargada de obtener la cantidad total vendida entre un rango de fechas
     * @var $fechaInicio es la fecha de inicio del rango
     * @var $fechaFin es la fecha de fin del rango
     * @return array asociativo con la cantidad vendida
     */
    public static function ObtenerCantidadProductosVendidos($fechaInicio, $fechaFin)
    {
        if (isset($fechaInicio) && isset($fechaFin) && is_string($fechaInicio) && is_string($fechaFin)) {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT SUM(cantidad) AS Total_Vendido FROM venta WHERE fecha_de_venta BETWEEN :fechaInicio AND :fechaFin");
            $consulta->bindValue(':fechaInicio', date($fechaInicio), PDO::PARAM_STR);
            $consulta->bindValue(':fechaFin', date($fechaFin), PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
    }
    /** Ejercicio E
     * Funcion que muestra los prodcutos de la tabla segun su ingreso y un limite
     * @var $cantidad es el limite de productos a mostrar
     * @return Array de la tabala prodcutos con los elementos
     */

    public static function Mostrar_N_ProductosEnviados(int $cantidad)
    {
        if(isset($cantidad)  && is_int($cantidad))
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM producto ORDER BY id_autoincremental ASC LIMIT :limite");
            $consulta->bindValue(':limite', $cantidad ,PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);	
        }
    }


    /** Ejercicio F
     * Funcion que decuelve los nombres de usuarios y productos de todas las ventas
     * @return Array con los nombres de usuarios y productos de todas las ventas
     */
    public static function MostrarNombreUsuarioYProductoPorVenta()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT usuario.Nombre AS Nombre_Usuario, producto.Nombre as Nombre_Producto FROM venta INNER JOIN usuario ON usuario.id_autoincremental = venta.id_usuario INNER JOIN producto ON producto.id_autoincremental = venta.id_producto");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);	

    }
    /** Ejecicio G
     * Funcion que meustra el monto resultante de multiplicar el precio del producto por la cantidad de ventas
     * @return Array con el monto de cada venta
     */
    public static function MostrarMontonPorVenta()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT venta.id_autoincremental AS ID_Venta,fecha_de_venta,(venta.cantidad * producto.precio) AS Monto_Venta FROM venta INNER JOIN producto on venta.id_producto = producto.id_autoincremental GROUP BY venta.id_autoincremental;");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);	
    }
    /** Ejecicio H
     * Funcion que muestra la cantidad vendida por Usuario
     * @var $idUsuario Es el id del usuario por el cual se va a consultar la cantidad vendida
     * @var $idProducto Es el id del producto por el cual se va a consultar la cantidad vendida
     * @return Array con los datos obtenidos
     */
    public static function MostrarCantidadVendidadPorUsuario ($idUsuario, $idProducto)
    {
        if (isset($idUsuario)  && is_int($idUsuario) && isset($idProducto)  && is_int($idProducto)) 
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT usuario.nombre AS Nombre_Usuario,usuario.apellido AS Apellido_Usuario, SUM(cantidad) AS Cantidad_Vendidas FROM venta INNER JOIN usuario ON venta.id_usuario = usuario.id_autoincremental WHERE venta.id_usuario = :usuario AND venta.id_producto = :producto");
            $consulta->bindValue(':usuario', $idUsuario ,PDO::PARAM_INT);
            $consulta->bindValue(':producto', $idProducto ,PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);	
        }
    }
    /** Ejecicio I
     * Funcion que muestra los datos de los porductos vendidos segun una localidad
     * @var $localidad es la localidad por la cual se van a consultar las ventas
     * @return Array con los datos obtenidos 
     */
    public static function MostrarProductosVendidosPorLocalidad($localidad)
    {
        if (isset($localidad)  && is_string($localidad)) {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT producto.codigo_de_barras AS COD,producto.nombre AS NOMBRE_PRODUCTO,producto.tipo AS TIPO, producto.precio AS precio  FROM venta INNER JOIN producto ON venta.id_producto = producto.id_autoincremental INNER JOIN usuario ON usuario.id_autoincremental = venta.id_usuario WHERE usuario.localidad = :localidad");
            $consulta->bindValue(':localidad', $localidad ,PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);	
        }
    }
    /** Ejecicio J
     * Muestra usuarios filtrados en base a una letra, permite filtrar por apellido o nombre
     * @var $letra es la letra a filtrar
     * @var $filtro por defecto se filtrara por nombre, se debe especificar si se quiere filtrar por apellido
     * @return Array con los datos obtenidos en base al filtro
     */
    public static function MostrarUsuariosFiltradoLetra($letra, $filtro)
    {
        if(isset($letra) && isset($filtro) && is_string($letra) && is_string($filtro))
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            if(strtolower($filtro) != "nombre" && strtolower($filtro) != "apellido" )
            {
                $filtro= "nombre";
            }
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuario WHERE ". $filtro. " LIKE '%". $letra ."%'");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        }
    }
    /** Ejercicio K
    * Muestra datos de ventas entre dos rangos de fecha, lo hice sin INNER para probar esta funcionalidad
    * @var $fechaInicio Es el inicio del rango
    * @var $fechaFin Es el fin del rango
    * @return Array con el ID venta, nombre de usuario y prodcuto
    */
    public static function MostrarVentasPorFecha($fechaInicio, $fechaFin)
    {
        if (isset($fechaInicio) && isset($fechaFin) && is_string($fechaInicio) && is_string($fechaFin)) {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT venta.id_autoincremental AS ID_VENTA, usuario.nombre AS NOMBRE_USUARIO, producto.nombre AS Nombre_Producto FROM venta, usuario, producto WHERE venta.fecha_de_venta BETWEEN :fechaInicio AND :fechaFin AND venta.id_usuario = usuario.id_autoincremental AND venta.id_producto = producto.id_autoincremental");
            $consulta->bindValue(':fechaInicio', date($fechaInicio), PDO::PARAM_STR);
            $consulta->bindValue(':fechaFin', date($fechaFin), PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        }

    }


}


?>