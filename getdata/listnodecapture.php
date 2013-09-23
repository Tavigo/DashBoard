<?php

	require_once("./rutinas.php");

	$collection = Coleccion("lbshistory");
	$sortida = $collection->distinct('nodeMAC');
	echo(json_encode($sortida));
?>

