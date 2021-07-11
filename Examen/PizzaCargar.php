<?


if(isset($_GET['sabor']) && isset($_GET['precio']) && isset($_GET['tipo'])&& isset($_GET['cantidad'])){

    $sabor =$_GET['sabor'];
    $precio = $_GET['precio'];
    $tipo = $_GET['tipo'];
    $cantidad = $_GET['cantidad'];

    Pizza::NuevaPizza($sabor, $precio, $tipo,$cantidad);


} 

?>