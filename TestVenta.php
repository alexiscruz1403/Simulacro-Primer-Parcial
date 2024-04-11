<?php
include 'Venta.php';

$unaFecha=trim(fgets(STDIN));
$otraFecha=trim(fgets(STDIN));
$unCliente=new Cliente("Alexis","Cruz","DNI",44555666);
$otroCliente=new Cliente("Juan","Perez","DNI",40100200);
$unaMoto=new Moto(1,1000,2019,"Benelli Imperiale 400 ",10);
$otraMoto=new Moto(2,1500,2020,"Zanella Zr 150 Ohc",50);
$otraMoto->setEstadoActiva(false);
$tercerMoto=new Moto(3,2000,2024,"Zanella Patagonian Eagle 250",5);
$arregloMoto=array($unaMoto);
$unaVenta=new Venta(1,$unaFecha,$unCliente,$arregloMoto);
echo $unaVenta;
echo "\n";
if($unaVenta->incorporarMoto($otraMoto)){
    echo "Moto agregada correctamente\n";
}else{
    echo "No se pudo agregar la moto\n\n";
}
echo $unaVenta;
echo "\n";
if($unaVenta->incorporarMoto($tercerMoto)){
    echo "Moto agregada correctamente\n";
}else{
    echo "No se pudo agregar la moto\n\n";
}
echo $unaVenta;
echo "\n";
$unaVenta->setNumero(2);
$unaVenta->setCliente($otroCliente);
$unaVenta->setFecha($otraFecha);
echo $unaVenta;
echo "\n";