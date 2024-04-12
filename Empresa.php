<?php

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
                "Direccion: ".$this->getDireccion()."\n";
        if(count($this->getArregloMotos())==0){
            $cadena=$cadena."No hay motos cargadas\n";
        }else{
            $cadena=$cadena."Motos: \n";
            foreach($this->getArregloMotos() as $moto){
                $cadena=$cadena."*".$moto->getDescripcion()."\n";
                if($moto->getEstadoActiva()){
                    $cadena=$cadena." Estado: Activa\n";
                }else{
                    $cadena=$cadena." Estado: No activa\n";
                }
            }
        }
        if(count($this->getArregloCliente())==0){
            $cadena=$cadena."No hay clientes cargados\n";
        }else{
            $cadena=$cadena."Clientes: \n";
            foreach($this->getArregloCliente() as $cliente){
                $cadena=$cadena."*".$cliente->getNombre()." ".$cliente->getApellido()."\n";
                if($cliente->getDadoBaja()){
                    $cadena=$cadena." Cliente dado de baja\n";
                }else{
                    $cadena=$cadena." Cliente activo\n";
                }
            }
        }
        if(count($this->getArregloVenta())==0){
            $cadena=$cadena."No hay ventas cargadas\n";
        }else{
            $cadena=$cadena."Ventas: \n";
            foreach($this->getArregloVenta() as $venta){
                $cadena=$cadena."*Numero ".$venta->getNumero()."\n".
                " Precio final: $".$venta->getPrecioFinal()."\n";
            }
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
     * Agrega una venta a la coleccion de ventas
     * @param Venta $unaVenta
     */
    public function agregarVenta($unaVenta){
        $arregloVentas=$this->getArregloVenta();
        array_push($arregloVentas,$unaVenta);
        $this->setArregloVenta($arregloVentas);
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
        $precioFinal=0;
        if(!$unCliente->getDadoBaja()){
            $arregloMotoVenta=array();
            foreach($colCodigosMoto as $codigo){
                $moto=$this->retornaMoto($codigo);
                if($moto!=null && $moto->getEstadoActiva()){
                    array_push($arregloMotoVenta,$moto);
                    $precioFinal=$precioFinal+$moto->darPrecioVenta();
                    $moto->setEstadoActiva(false);
                }
            }
            if(count($arregloMotoVenta)!=0){
                echo "INGRESE LOS DATOS DE LA VENTA\n";
                echo "Numero de venta: ";
                $numero=trim(fgets(STDIN));
                echo "Fecha: ";
                $fecha=trim(fgets(STDIN));
                $unaVenta=new Venta($numero,$fecha,$unCliente,$arregloMotoVenta,$precioFinal);
                $this->agregarVenta($unaVenta);
            }
            else{
                $precioFinal=-1;
            }
        }else{
            $precioFinal=-1;
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