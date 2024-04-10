<?php
include_once 'Cliente.php';

//Main

$unCliente=new Cliente("Alexis","Cruz","DNI",44555666);
echo $unCliente;
$unCliente->setNombre("Juan");
$unCliente->setApellido("Perez");
$unCliente->setTipoDocumento("Pasaporte");
$unCliente->setNumeroDocumento("1");
echo $unCliente;