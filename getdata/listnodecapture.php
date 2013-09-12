<?php
	// conectar
	$m = new MongoClient();
	// seleccionar una base de datos
	$db = $m->lbs;
	// seleccionar una colección (equivalente a una tabla en una base de datos relacional)
	$collection = $db->lbshistory;
	$sortida = $collection->distinct('nodeMAC');
	echo(json_encode($sortida));
?>

