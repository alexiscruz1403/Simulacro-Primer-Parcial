<?php
include_once 'Moto.php';
include_once 'Cliente.php';
include_once 'Venta.php';
include_once 'Empresa.php';

//Main

//Punto 1
$objCliente1=new Cliente("Alexis","Cruz","DNI",44555666);
$objCliente2=new Cliente("Juan","Perez","DNI",40100200);
//Punto 2
$objMoto1=new Moto(11,2230000,2022,"Benelli Imperiale 400",85);
$objMoto2=new Moto(12,584000,2021,"Zanella Zr 150 Ohc",70);
$objMoto3=new Moto(13,999900,2023,"Zanella Patagonian Eagle 250",55);
$objMoto3->setEstadoActiva(false);
//Punto 4
$arregloMoto=array($objMoto1,$objMoto2,$objMoto3);
$arregloCliente=array($objCliente1,$objCliente2);
$arregloVenta=array();
$unaEmpresa=new Empresa("Alta Gama","Av Argentina 123",$arregloMoto,$arregloCliente,$arregloVenta);
//Punto 5
echo "PUNTO 5\n";
$colCodigos=array(11,12,13);
$precioFinal=$unaEmpresa->registrarVenta($colCodigos,$objCliente2);
if($precioFinal!=-1){
    echo "El precio final de la venta es: $".$precioFinal."\n";
}else{
    echo "No se pudo realizar la venta\n";
}
//Punto 6
echo "PUNTO 6\n";
$colCodigos=array(0);
$precioFinal=$unaEmpresa->registrarVenta($colCodigos,$objCliente2);
if($precioFinal!=-1){
    echo "El precio final de la venta es: ".$precioFinal."\n";
}else{
    echo "No se pudo realizar la venta\n";
}
//Punto 7
echo "PUNTO 7\n";
$colCodigos=array(2);
$precioFinal=$unaEmpresa->registrarVenta($colCodigos,$objCliente2);
if($precioFinal!=-1){
    echo "El precio final de la venta es: ".$precioFinal."\n";
}else{
    echo "No se pudo realizar la venta\n";
}
//Punto 8
echo "PUNTO 8\n";
$colVentas=$unaEmpresa->retornarVentasXCliente($objCliente1->getTipoDocumento(),$objCliente1->getNumeroDocumento());
if($colVentas==null){
    echo "No se registraron ventas para este cliente\n";
}
else{
    echo "Ventas al cliente con dni ".$objCliente1->getNumeroDocumento().": \n";
    foreach($colVentas as $venta){
        echo $venta."\n";
    }
}
//Punto 9
echo "PUNTO 9\n";
$colVentas=$unaEmpresa->retornarVentasXCliente($objCliente2->getTipoDocumento(),$objCliente2->getNumeroDocumento());
if($colVentas==null){
    echo "No se registraron ventas para este cliente\n";
}
else{
    echo "Ventas al cliente con dni ".$objCliente2->getNumeroDocumento().": \n";
    foreach($colVentas as $venta){
        echo $venta."\n";
    }
}
//Punto 10
echo "PUNTO 10\n";
echo $unaEmpresa;