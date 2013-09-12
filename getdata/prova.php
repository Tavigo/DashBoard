<?php

	$nodeMAC=htmlspecialchars($_REQUEST["nodeMAC"]);
	$RSSI=htmlspecialchars($_REQUEST["RSSI"]);
	// conectar
	$m = new MongoClient();
	// seleccionar una base de datos
	$db = $m->lbs;
	// seleccionar una colección (equivalente a una tabla en una base de datos relacional)
	$collection = $db->lbshistory;
	
	$opt= array(array('$project' => array('FechaCaptura'=>1)), 
	            array('$match' => array('nodeMAC' => "$nodeMAC", 'RSSI' =>(int)$RSSI ))
			    );
	
	echo(json_encode($opt));
	
	$sortida = $collection->aggregate($opt);
	
	
	echo(json_encode($sortida));
?>
