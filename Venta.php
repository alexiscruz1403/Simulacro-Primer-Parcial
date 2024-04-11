<?php
include_once 'Fecha.php';
include_once 'Moto.php';
include_once 'Cliente.php';

class Venta{

    //Atributos
    private $numero; //Int
    private $objFecha; //Instancia Fecha
    private $objCliente; //Instancia Cliente
    private $colObjMoto; //Arreglo Instancias Moto
    private $precioFinal; //Double

    //Constructor
    public function __construct($unNumero, $unaFecha, $unCliente, $unArregloMoto){
        $this->numero=$unNumero;
        $this->objFecha=$unaFecha;
        $this->objCliente=$unCliente;
        $this->colObjMoto=$unArregloMoto;
        $this->precioFinal=$this->calculaPrecioFinal();
    }

    //Modificadores
    public function setNumero($unNumero){
        $this->numero=$unNumero;
    }

    public function setFecha($unaFecha){
        $this->objFecha=$unaFecha;
    }

    public function setCliente($unCliente){
        $this->objCliente=$unCliente;
    }

    public function setArregloMotos($unArregloMoto){
        $this->colObjMoto=$unArregloMoto;
    }

    public function setPrecioFinal($unPrecioFinal){
        $this->precioFinal=$unPrecioFinal;
    }

    //Observadores
    public function getNumero(){
        return $this->numero;
    }

    public function getFecha(){
        return $this->objFecha;
    }

    public function getCliente(){
        return $this->objCliente;
    }
    
    public function getArregloMotos(){
        return $this->colObjMoto;
    }

    public function getPrecioFinal(){
        return $this->precioFinal;
    }

    public function __toString(){
        $cadena="Codigo: ".$this->getNumero()."\n".
                "Fecha: ".$this->getFecha()->fechaAbreviada().
                "Cliente: ".$this->getCliente()->getNombre()." ".$this->getCliente()->getApellido()."\n".
                "Motos: \n\n";
        foreach($this->getArregloMotos() as $moto){
            $cadena=$cadena.$moto."\n";
        }
        $cadena=$cadena."Precio final: ".$this->getPrecioFinal()."\n";
        return $cadena;
    }

    //Propios

    /**
     * Calcula el precio final de un arreglo de obejtos Moto
     * @return double
     */
    public function calculaPrecioFinal(){
        $precio=0;
        foreach($this->getArregloMotos() as $moto){
            $precio=$precio+$moto->darPrecioVenta();
        }
        return $precio;
    }

    /**
     * Agrega una instancia de la clase moto al arreglo de colObjMoto
     * Debe cumplirse que el usuario no este dado de baja y que la moto este en estado activa
     * Devuelve true si se pudo ingresar la moto o false en caso contrario
     * @param Moto $unaMoto
     * @return boolean
     */
    public function incorporarMoto($unaMoto){
        $incorporado=false;
        if(!$this->getCliente()->getDadoBaja() && $unaMoto->getEstadoActiva()){
            $arreglo=$this->getArregloMotos();
            array_push($arreglo,$unaMoto);
            $this->setArregloMotos($arreglo);
            $incorporado=true;
            $this->setPrecioFinal($this->getPrecioFinal()+$unaMoto->darPrecioVenta());
        }
        return $incorporado;
    }
}