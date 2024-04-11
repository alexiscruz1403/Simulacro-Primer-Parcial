<?php
include_once 'Cliente.php';
include_once 'Moto.php';
include_once 'Venta.php';

class Empresa{

    //Atributos
    private $denominacion; //String
    private $direccion; //String
    private $colObjCliente; //Arreglo de Objetos Cliente
    private $colObjMoto; //Arreglo de Objetos Moto
    private $colObjVenta; //Arreglo de Objetos Venta

    //Constructor
    public function __construct($unaDenominacion, $unaDireccion, $unArregloMoto, $unArregloCliente, $unArregloVenta){
        $this->denominacion=$unaDenominacion;
        $this->direccion=$unaDireccion;
        $this->colObjMoto=$unArregloMoto;
        $this->colObjCliente=$unArregloCliente;
        $this->colObjVenta=$unArregloVenta;
    }

    //Modificadores
    public function setDenominacion($unaDenominacion){
        $this->denominacion=$unaDenominacion;
    }
    public function setDireccion($unaDireccion){
        $this->direccion=$unaDireccion;
    }
    public function setArregloMoto($unArregloMoto){
        $this->colObjMoto=$unArregloMoto;
    }
    public function setArregloCliente($unArregloCliente){
        $this->colObjCliente=$unArregloCliente;
    }
    public function setArregloVenta($unArregloVenta){
        $this->colObjVenta=$unArregloVenta;
    }

    //Observadores
    public function getDenominacion(){
        return $this->denominacion;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getArregloMotos(){
        return $this->colObjMoto;
    }
    public function getArregloCliente(){
        return $this->colObjCliente;
    }
    public function getArregloVenta(){
        return $this->colObjVenta;
    }
    public function __toString(){
        $cadena="Denominacion: ".$this->getDenominacion()."\n".
                "Direccion: ".$this->getDireccion()."\n".
                "Motos: \n\n";
        foreach($this->getArregloMotos() as $moto){
            $cadena=$cadena.$moto."\n\n";
        }
        $cadena=$cadena."Clientes: \n\n";
        foreach($this->getArregloCliente() as $cliente){
            $cadena=$cadena.$cliente."\n\n";
        }
        $cadena=$cadena."Ventas: \n\n";
        foreach($this->getArregloVenta() as $venta){
            $cadena=$cadena.$venta."\n\n";
        }
        return $cadena;
    }

    //Propios

    /**
     * Retorna el objeto moto dentro de la coleccion de motos ubicado en la posicion dada por parametro
     * Retorna null enc caso de ingresar una posicion invalida
     * @param int $posicion
     * @return Moto
     */
    public function darMotoEn($posicion){
        $cantidadMotos=count($this->getArregloMotos());
        if($cantidadMotos!=0 && $posicion>=0 && $posicion<$cantidadMotos){
            $moto=$this->getArregloMotos()[$posicion];
        }else{
            $moto=null;
        }
        return $moto;
    }

    /**
     * Retorna el objeto venta dentro de la coleccion de ventas ubicado en la posicion dada por parametro
     * Retorna null enc caso de ingresar una posicion invalida
     * @param int $posicion
     * @return Venta
     */
    public function darVentaEn($posicion){
        $cantidadVentas=count($this->getArregloVenta());
        if($cantidadVentas!=0 && $posicion>=0 && $posicion<$cantidadVentas){
            $venta=$this->getArregloMotos()[$posicion];
        }else{
            $venta=null;
        }
        return $venta;
    }

    /**
     * Retorna el objeto Moto dentro de la coleccion de motos cuyo codigo coincida con el ingresado por parametro
     * Si no se encuentra el codigo cargado en la coleccion, retorna null
     * @param string $unCodigo
     * @return Moto
     */
    public function retornaMoto($codigoMoto){
        $encontrado=false;
        $i=0;
        $cantidadMotos=count($this->getArregloMotos());
        $moto=null;
        while($i<$cantidadMotos && !$encontrado){
            if($this->darMotoEn($i)->getCodigo()==$codigoMoto){
                $moto=$this->darMotoEn($i);
                $encontrado=true;
            }
            $i++;
        }
        return $moto;
    }

    /**
     * Crea una instancia venta y la agrega a la coleccion de ventas
     * Antes verifica que el cliente no esta dado de baja
     * Antes verifica que las motos esten disponibles para la venta
     * Si una moto no esta disponible, no la agrega a la venta pero si a las demas
     * La venta se cancela si el cliente esta dado de baja o si ninguna moto esta a la venta
     * Devuelve el precio final si se pudo registrar la venta o -1 en caso contrario
     * @param array $colCodigosMoto
     * @param Cliente $unCliente
     * @return boolean
     */
    public function registrarVenta($colCodigosMoto, $unCliente){
        $precioFinal=-1;
        if(!$unCliente->getDadoBaja()){
            $arregloMotosVenta=array();
            foreach($colCodigosMoto as $codigo){
                $unaMoto=$this->retornaMoto($codigo);
                if($unaMoto!=null && $unaMoto->getEstadoActiva()){
                    array_push($arregloMotosVenta,$unaMoto);
                }
            }
            if(count($arregloMotosVenta)!=0){
                echo "Ingrese el numero de venta: ";
                $codigoVenta=trim(fgets(STDIN));
                echo "Ingrese una fecha: ";
                $fecha=trim(fgets(STDIN));
                $unaVenta=new Venta($codigoVenta,$fecha,$unCliente,$arregloMotosVenta);
                $arregloVenta=$this->getArregloVenta();
                array_push($arregloVenta,$unaVenta);
                $this->setArregloVenta($arregloVenta);
                $precioFinal=$unaVenta->getPrecioFinal();
            }
        }
        return $precioFinal;
    }

    /**
     * Retorna una coleccion de ventas realizadas al cliente cuyo tipo y numero de documento coinciden con los ingresados por parametro
     * Si no encuentran ventas realizada a ese cliente, se retorna null
     * @param string $tipoDocumento
     * @param int $numeroDocumento
     * @return array
     */
    public function retornarVentasXCliente($tipoDocumento,$numeroDocumento){
        $arregloVentas=array();
        foreach($this->getArregloVenta() as $venta){
            if($venta->getCliente()->getTipoDocumento()==$tipoDocumento && $venta->getCliente()->getNumeroDocumento()==$numeroDocumento){
                array_push($arregloVentas,$venta);
            }
        }
        if(count($arregloVentas)==0){
            $arregloVentas=null;
        }
        return $arregloVentas;
    }
}