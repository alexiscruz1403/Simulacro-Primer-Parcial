<?php
Class Fecha{
    //Atributos
    private $dia;
    private $mes;
    private $anio;

    //Constructor
    public function __construct($unDia,$unMes,$unAnio){
        $valido=true;
        if(($unDia>0 && $unDia<32) && ($unMes>0 && $unMes<13) && ($unAnio>0)){
            switch($unMes){
                case 4:case 6:case 9:case 11: //Si el mes es abril, junio, septiembre o noviembre
                    if($unDia>30){           //debe tener 30 dias o menos
                        $valido=false;
                    }
                    break;
                case 2:
                    if(($unAnio%4==0 && $unAnio%100!=0) || $unAnio%400==0){ //Si el mes es febrero y es bisiesto
                        if($unDia>29){                                      //debe tener 29 dias o menos
                            $valido=false;
                        }
                    }else{
                        if($unDia>28){          //Si el mes es febrero y no es bisiesto
                            $valido=false;      //debe tener 28 dias o menos
                        } 
                    }
                    break;
            }
        }
        else{
            $valido=false;
        }
        if($valido){
            $this->setDia($unDia);
            $this->setMes($unMes);
            $this->setAnio($unAnio);
        }
        else{
            throw new ErrorException("Fecha Invalida");
        }
    }
    //Observadores
    public function getDia(){
        return $this->dia;
    }
    public function getMes(){
        return $this->mes;
    }
    public function getAnio(){
        return $this->anio;
    }
    public function fechaAbreviada(){
        $cadenaRetorno="";
        if($this->getDia()<10){
            $cadenaRetorno=$cadenaRetorno."0";
        }
        $cadenaRetorno=$cadenaRetorno.$this->getDia()."/";
        if($this->getMes()<10){
            $cadenaRetorno=$cadenaRetorno."0";
        }
        $cadenaRetorno=$cadenaRetorno.$this->getMes()."/";
        if($this->getAnio()<10){
            $cadenaRetorno=$cadenaRetorno."000".$this->getAnio()."\n";
        }else{
            if($this->getAnio()<100){
                $cadenaRetorno=$cadenaRetorno."00".$this->getAnio()."\n";
            }else{
                if($this->getAnio()<1000){
                    $cadenaRetorno=$cadenaRetorno."0".$this->getAnio()."\n";
                }else{
                    $cadenaRetorno=$cadenaRetorno.$this->getAnio()."\n";
                }
            }
        }
        return $cadenaRetorno;
    }
    public function fechaExtendida(){
        $mesExtendido="";
        switch($this->getMes()){
            case 1:
                $mesExtendido="Enero";
                break;
            case 2:
                $mesExtendido="Febrero";
                break;
            case 3:
                $mesExtendido="Marzo";
                break;
            case 4:
                $mesExtendido="Abril";
                break;
            case 5:
                $mesExtendido="Mayo";
                break;
            case 6:
                $mesExtendido="Junio";
                break;
            case 7:
                $mesExtendido="Julio";
                break;
            case 8:
                $mesExtendido="Agosto";
                break;
            case 9:
                $mesExtendido="Septiembre";
                break;
            case 10:
                $mesExtendido="Octubre";
                break;
            case 11:
                $mesExtendido="Noviembre";
                break;
            case 12:
                $mesExtendido="Diciembre";
                break;
        }
        return $this->getDia()." de ".$mesExtendido." de ".$this->getAnio()."\n";
    }

    //Modificadores
    public function setDia($unDia){
        $this->dia=$unDia;
    }
    public function setMes($unMes){
        $this->mes=$unMes;
    }
    public function setAnio($unAnio){
        $this->anio=$unAnio;
    }

    //Propios
    /**
     * Verifica si el año es bisiesto
     * @return boolean
     */
    public function esBisiesto(){
        $bisiesto=false;
        if(($this->getAnio()%4==0 && $this->getAnio()%100!=0) || $this->getAnio()%400==0){
            $bisiesto=true;
        }
        return $bisiesto;
    }
    /**
     * Incrementa un dia a la fecha
     */
    public function incrementarUnDia(){
        switch($this->getMes()){
            case 4:case 6:case 9:case 11:
                if($this->getDia()==30){
                    $this->setMes($this->getMes()+1);
                    $this->setDia(1);                
                }else{
                    $this->setDia($this->getDia()+1);
                }
                break;
            case 2:
                if($this->esBisiesto()){
                    if($this->getDia()==29){
                        $this->setMes(3);
                        $this->setDia(1);
                    }
                    else{
                        $this->setDia($this->getDia()+1);
                    }
                }else{
                    if($this->getDia()==28){
                        $this->setMes(3);
                        $this->setDia(1);
                    }
                    else{
                        $this->setDia($this->getDia()+1);
                    }
                }
                break;
            case 1:case 3:case 5:case 7:case 8:case 10:
                if($this->getDia()==31){
                    $this->setMes($this->getMes()+1);
                    $this->setDia(1);                
                }else{
                    $this->setDia($this->getDia()+1);
                }
                break;
            case 12:
                if($this->getDia()==31){
                    $this->setMes(1);
                    $this->setDia(1);
                    $this->setAnio($this->getAnio()+1);                
                }else{
                    $this->setDia($this->getDia()+1);
                }
        }
    }

    /**
     * Retorna la cantidad de dias del mes ingresado por parametro
     * En el caso de febrero, verifica si el año es o no biciesto
     * @return int
     */
    public function cantidadDiasEnMes(){
        switch($this->getMes()){
            case 1:case 3:case 5:case 7:case 8:case 10:case 12:
                $dias=31;
                break;
            case 4:case 6:case 9:case 11:
                $dias=30;
                break;
            case 2:
                if($this->esBisiesto()){
                    $dias=29;
                }else{
                    $dias=28;
                }
        }
        return $dias;
    }

    /**
     * Retorna true si la fecha ingresada es igual a la fecha ingresada por parametro y false si es distinta
     * @param Fecha $hoy
     * @return boolean
     */
    public function equals($unaFecha){
        return $this->getDia()==$unaFecha->getDia() && $this->getMes()==$unaFecha->getMes() && $this->getAnio()==$unaFecha->getAnio();
    }
    
}