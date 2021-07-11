<?php
require_once "./Usuario/Usuario.php";
require_once "./Producto/Producto.php";
require_once "./Ventas/Venta.php";

/**   
 *Aplicación Nº 28 ( Listado BD)
Archivo: listado.php
método:GET
Recibe qué listado va a retornar(ej:usuarios,productos,ventas)
cada objeto o clase tendrán los métodos para responder a la petición
devolviendo un listado <ul> o tabla de html <table>
 */

if(isset($_GET['listado'])){

   $listado = $_GET['listado'];

   switch(strtolower($listado))
   {
      case "usuarios":
         {
            $usuarios=Usuario::TraerTodoLosUsuarios();
            Usuario::ListarUsuarios($usuarios);
            break;
         }
      case "ventas":
         {
            $ventas = Venta::TraerTodasLasVentas();
            Venta::ListarVentas($ventas);
            break;
         }
      case "productos":
         {
            $productos = Producto::TraerTodoLosProductos();
            Producto::ListarProductos($productos);
            break;
         }
      default:{
         echo "No se reconocio el listado solicitado\n";
      }
      
   }

}

?>