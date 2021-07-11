<?php
require_once "punto.php";

class Rectangulo{
    private Punto $_vertice1;
    private Punto $_vertice2;
    private Punto $_vertice3;
    private Punto $_vertice4;
    public $area;
    public $ladoUno;
    public $ladoDos;
    public $perimetro;

    /**
     * Consrtuctor de Rectangulo
     */
    public function __construct(Punto $v1, Punto $v3)
    {
        if (is_a($v1, "Punto") && is_a($v3, "Punto")) {
            $this->_vertice1 = $v1;
            $this->_vertice3 = $v3;
            $this->_vertice2 = new Punto($this->_vertice1->GetX(), $this->_vertice3->GetY());
            $this->_vertice4 = new Punto($this->_vertice3->GetX(), $this->_vertice1->GetY());
            $this->CalcularDatos();
        }
    }

    private function CalcularDatos()
    {
        $this->ladoUno = $this->_vertice1->GetY() - $this->_vertice2->GetY();
        $this->ladoDos = $this->_vertice3->GetX() - $this->_vertice2->GetX();
        $this->perimetro = 2* ($this->ladoUno + $this->ladoDos);
        $this->area = $this->ladoUno * $this->ladoDos;
    }

    public function Dibujar()
    {
        $dibujo="El lado uno es igual a: ". $this->ladoUno ."<br>El lado dos a:". $this->ladoDos."<br>El area es: ". $this->area."<br>El Perimetro es: ".$this->perimetro."<br><br>";
        for ($i=0; $i < $this->ladoUno ; $i++){
           for ($j=0; $j <$this->ladoDos; $j++){
                $dibujo .= "*";
           }
           $dibujo .= "<br>";
        }
        return $dibujo;
    }
}
?>