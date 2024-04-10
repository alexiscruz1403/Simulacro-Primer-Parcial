<?php

class Cliente{
    //Atributos
    private $nombre; //String
    private $apellido; //String
    private $tipoDocumento; //String
    private $numeroDocumento; //Int
    private $dadoBaja; //Boolean;

    //Constructor 
    public function __construct($unNombre, $unApellido, $unTipoDocumento, $unNumeroDocumento){
        $this->nombre=$unNombre;
        $this->apellido=$unApellido;
        $this->tipoDocumento=$unTipoDocumento;
        $this->numeroDocumento=$unNumeroDocumento;
        $this->dadoBaja=false;
    }

    //Modificadores

    public function setNombre($unNombre){
        $this->nombre=$unNombre;
    }

    public function setApellido($unApellido){
        $this->apellido=$unApellido;
    }

    public function setTipoDocumento($unTipoDocumento){
        $this->tipoDocumento=$unTipoDocumento;
    }

    public function setNumeroDocumento($unNumeroDocumento){
        $this->numeroDocumento=$unNumeroDocumento;
    }

    //Observadores

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellido(){
        return $this->apellido;
    }

    public function getTipoDocumento(){
        return $this->tipoDocumento;
    }

    public function getNumeroDocumento(){
        return $this->numeroDocumento;
    }

    public function __toString(){
        return "Nombre: ".$this->getNombre()."\n".
                "Apellido: ".$this->getApellido()."\n".
                "Tipo de documento: ".$this->getTipoDocumento()."\n".
                "Numero Documento: ".$this->getNumeroDocumento()."\n";
    }
}