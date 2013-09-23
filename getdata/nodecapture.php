<?php

	require_once("./rutinas.php");
	
	$collection = Coleccion("lbshistory");
	
	$matchopt=[];
	// filtro de nodeMAC
	if (isset($_REQUEST["nodeMAC"])) {
		$nodeMAC=htmlspecialchars($_REQUEST["nodeMAC"]);
		$matchopt=array_merge($matchopt, array("nodeMAC"=>"$nodeMAC"));
	}
	
	//Filtro de fromMAC
	if (isset($_REQUEST["fromMAC"])){
		$fromMAC=htmlspecialchars($_REQUEST["fromMAC"]);
		$matchopt=array_merge($matchopt, array("fromMAC"=>"$fromMAC"));
	}
	// Filtro ventana temporal
	if (isset($_REQUEST["interval"])) {
		$TopTimestamp = FechaUltimaSenal($matchopt, $collection);
		$time_ini=$TopTimestamp - ($_REQUEST["interval"] * 6000);
		$matchopt=array_merge($matchopt, array("SentTimestamp"=> array('$gt'=> $time_ini)));
	}
		
	$opt= array(array('$match' => $matchopt),
			    array('$group' => array( "_id" => '$RSSI', "count" => array('$sum' => 1))),
				array('$sort' => array("_id"=>-1)));
	
	//echo(json_encode($opt));
	
	$sortida = $collection->aggregate($opt);
	$swfirst=true;
	$valor=[];
	foreach ($sortida['result'] as $taula) {
		if ($swfirst == true) {
			$swfirst = false;
			array_push($valor,array("RSSI","frames"));
			//array_push($valor, array(1,0));
		}
		array_push($valor, array($taula['_id'],$taula['count']));
	}
	//Retornem el valor de la consulta.
	echo(json_encode($valor));
?>
