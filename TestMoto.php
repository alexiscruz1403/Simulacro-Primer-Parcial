<?php
include_once 'Moto.php';

//Main

$unaMoto=new Moto("A1",100000,2019,"Moto linda",100);
echo $unaMoto;
if($unaMoto->darPrecioVenta()!=-1){
    echo "El precio de la moto es: ".$unaMoto->darPrecioVenta()."\n";
}else{
    echo "La moto no se encuentra a la venta";
}
$unaMoto->setEstadoActiva(false);
if($unaMoto->darPrecioVenta()!=-1){
    echo "El precio de la moto es: ".$unaMoto->darPrecioVenta();
}else{
    echo "La moto no se encuentra a la venta";
}