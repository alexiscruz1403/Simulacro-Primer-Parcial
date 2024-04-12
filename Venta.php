<?php

class Venta{

    //Atributos
    private $numero; //Int
    private $fecha; //String
    private $objCliente; //Instancia Cliente
    private $colObjMoto; //Arreglo Instancias Moto
    private $precioFinal; //Double

    //Constructor
    public function __construct($unNumero, $unaFecha, $unCliente, $unArregloMoto, $unPrecio){
        $this->numero=$unNumero;
        $this->fecha=$unaFecha;
        $this->objCliente=$unCliente;
        $this->colObjMoto=$unArregloMoto;
        $this->precioFinal=$unPrecio;
    }

    //Modificadores
    public function setNumero($unNumero){
        $this->numero=$unNumero;
    }

    public function setFecha($unaFecha){
        $this->fecha=$unaFecha;
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
        return $this->fecha;
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
                "Fecha: ".$this->getFecha()."\n".
                "Cliente: ".$this->getCliente()->getNombre()." ".$this->getCliente()->getApellido()."\n".
                "Motos: \n";
        foreach($this->getArregloMotos() as $moto){
            $cadena=$cadena."*".$moto->getDescripcion()."\n";
        }
        $cadena=$cadena."Precio final: ".$this->getPrecioFinal()."\n";
        return $cadena;
    }

    //Propios

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