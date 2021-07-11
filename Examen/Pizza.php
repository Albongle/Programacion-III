<?php

class Pizza
{
    private $id;
    private $sabor;
    private $precio;
    private $tipo;
    private $cantidad;
    const RUTAID = "./archivos/ultimoidpizzas.txt";
    const RUTAJSON = "./archivos/pizzas.json";

    public function __construct()
    {

    }

    public function SetDatos ($sabor, $precio, $tipo,$cantidad=0,$id=-1){
        $this->SetId($id);
        $this->sabor = $sabor;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->cantidad = $cantidad;
    }

    public function SetSabor($sabor)
    {
        if(isset($sabor))
        {
            $this->sabor = $sabor;
        }
        
    }
    public function SetTipo($tipo)
    {
        if(isset($tipo))
        {
            $this->tipo = $tipo;
        }
        
    }
    public function SetPrecio($precio)
    {
        if(isset($precio))
        {
            $this->precio = $precio;
        }
        
    }
    public function GetPrecio()
    {
        return $this->precio;

    }
    public function SetCantidad($cantidad)
    {
        if(isset($cantidad))
        {
            $this->cantidad = $cantidad;
        }
        
    }
    public function GetCantidad()
    {
        return $this->cantidad;
        
    }

    private function SetId($id)
    {
        if($id == -1)
        {
            $idLeido=self::LeerUltimoID(self::RUTAID);
            if($idLeido == -1){
                $this->id = 0;
                
            }else{
                $idLeido++;
                $this->id = $idLeido;
            }
            self::EscribirUltimoID(self::RUTAID,$this->id);
        }
        else{
            $this->id = $id;
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
        if(isset ($ruta) && is_string($ruta) && isset($dato) && is_numeric($dato))
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
     * Funcion provada que convierte los datos de la clase en un array asocitivo, permitiendo usarlo con TXT, CSV y JSON
     */
    private function GetObjeto()
    {
        return array("id"=>$this->id,"sabor"=>$this->sabor,"precio"=>$this->precio,"tipo"=>$this->tipo,"cantidad"=>$this->cantidad);
    }

    public function PizzaToJSON()
    {
        if(isset($this))
        {
            return json_encode($this->GetObjeto())."\r\n";
        }
    }

    public static function LeerArchivo(string $ruta)
    {
        $returnArray=  array();
        if(isset($ruta) && is_string($ruta))
        {
            if (($archivo=fopen($ruta, "r"))) 
            {
                while (($datos = fgets($archivo))) 
                {
                    $datos=json_decode($datos);
                    $pizza = new Pizza();
                    $pizza->SetDatos($datos->sabor,$datos->precio,$datos->tipo,$datos->cantidad,$datos->id);
                    array_push($returnArray,$pizza);
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


    public function Equals(Pizza $pizza)
    {
        $returnAux = false;
        if(isset($pizza) && is_a($pizza,"Pizza"))
        {
            if($pizza->sabor == $this->sabor)
            {
                $returnAux = true;
            }
        }
        return $returnAux;
    }

    public Function ValidarPizza($array)
    {
        $returnAux =-1;
        if(isset($array) && is_array($array))
        {
            foreach ($array as $key=> $value) 
            {
                if($this->Equals($value))
                {
                    $returnAux =$key;
                    break;  
                }
            }
        }
        return $returnAux;
    }

    public static function NuevaPizza($sabor, $precio, $tipo,$cantidad)
    {
        $pizzaAux= new Pizza();
        $pizzaAux->SetDatos($sabor, $precio, $tipo,$cantidad);      
        $arrayProdcutos = self::LeerArchivo(self::RUTAJSON);
        $validacionPizza= $pizzaAux->ValidarPizza($arrayProdcutos);
        
        if($validacionPizza< 0)
        {
            if(self::AgregarRegistros($pizzaAux,self::RUTAJSON)){
                echo "Se agrego un nueva pizza\n";
            }
            else{
                echo "No se pudo hacer nada";
            } 
        }
        else if($validacionPizza>= 0)
        {
            $cantidadAux=($arrayProdcutos[$validacionPizza]->GetCantidad() + $cantidad);
            $arrayProdcutos[$validacionPizza]->SetCantidad($cantidadAux);
            $arrayProdcutos[$validacionPizza]->SetPrecio($precio);
            if(self::ModificarRegistros($arrayProdcutos,self::RUTAJSON)){
                echo "Se actualizo la cantidad\n"; 
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
            self::GuardarArchivo($registro->PizzaToJSON(),$archivo);
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
                $key == 0 ? self::GuardarArchivo($value->PizzaToJSON(),$archivo,"w") : self::GuardarArchivo($value->PizzaToJSON(),$archivo);
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








}



?>