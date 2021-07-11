<?php

require_once "./data/AccesoDatos.php";
class Venta{

    public static function AltaVentaBD($mail, $npedido, $sabor,$tipo,$cantidad )
	{
        $returnAux = false;
        if (isset($npedido) && isset($mail)){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO registros (fecha,n_pedido,mail,sabor,tipo,cantidad)VALUES(:fecha,:npedido,:mail,:sabor,:tipo,:cantidad)");
            $consulta->bindValue(':npedido',$npedido, PDO::PARAM_INT);
            $consulta->bindValue(':cantidad',$cantidad, PDO::PARAM_INT);
            $consulta->bindValue(':mail',$mail,PDO::PARAM_STR);
            $consulta->bindValue(':fecha',date("Y-m-d"),PDO::PARAM_STR);
            $consulta->bindValue(':sabor',$sabor,PDO::PARAM_STR);
            $consulta->bindValue(':tipo',$tipo,PDO::PARAM_STR);
            $consulta->execute();
            $returnAux = $objetoAccesoDato->RetornarUltimoIdInsertado();
        }
        return $returnAux;		
	}
}


?>