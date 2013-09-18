<?php
	// conectar a la base de datos
	$m = new MongoClient("5.56.58.76");
	// seleccionar una base de datos
	$db = $m->lbs;
	// seleccionar una colección (equivalente a una tabla en una base de datos relacional)
	$collection = $db->lbsRSSIavg;
?>
