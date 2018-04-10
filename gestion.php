<?php
require"clases/estacionamiento.php";
require"clases/vehiculo.php";


$patente=$_POST['patente'];
$accion=$_POST['estacionar'];

if($accion=="ingreso")
{

	estacionamiento::estacionar($patente, $horaingreso);
}
else
{
	estacionamiento::Sacar($patente);

		//var_dump($datos);
}

header("location:index.php");
?>
