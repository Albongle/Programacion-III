<?php
require_once "./data/AccesoDatos.php";
class ConsultasBD
{
    public static function ObtenerCantidadPizzasVendidas()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("SELECT SUM(cantidad) AS Total_Vendido FROM registros");
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
        
    }
    public static function ObtenerListadoDeVentas($fechaInicio, $fechaFin)
    {
        if (isset($fechaInicio) && isset($fechaFin) && is_string($fechaInicio) && is_string($fechaFin)) {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM registros WHERE fecha_de_venta BETWEEN :fechaInicio AND :fechaFin ORDER BY sabor ASC");
            $consulta->bindValue(':fechaInicio', date($fechaInicio), PDO::PARAM_STR);
            $consulta->bindValue(':fechaFin', date($fechaFin), PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        }
    }
    public static function ObtenerListadoDeVentasPorUsuario($usuario)
    {
        if (isset($usuario)) {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM registros WHERE mail = :usuario");
            $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        }
    }
    public static function ObtenerListadoDeVentasPorSabor($sabor)
    {
        if (isset($sabor)) {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM registros WHERE sabor = :sabor");
            $consulta->bindValue(':sabor', $sabor, PDO::PARAM_STR);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        }
    }
}
?>