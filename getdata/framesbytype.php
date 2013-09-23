<?php

	require_once("./rutinas.php");
	
	$collection = Coleccion("lbshistory");
	
	$matchopt=[];
	// filtro de nodeMAC
	if (isset($_REQUEST["nodeMAC"])) {
		$nodeMAC=htmlspecialchars($_REQUEST["nodeMAC"]);
		$matchopt=array_merge($matchopt, array("nodeMAC"=>"$nodeMAC"));
	}
	
	// Filtro ventana temporal
	if (isset($_REQUEST["interval"])) {
		$TopTimestamp = FechaUltimaSenal($matchopt, $collection);
		$time_ini=$TopTimestamp - ($_REQUEST["interval"] * 6000);
		$matchopt=array_merge($matchopt, array("SentTimestamp"=> array('$gt'=> $time_ini)));
	}
		
	$opt= array(array('$match' => $matchopt),
			    array('$group' => array( "_id" => '$TipoFrame', "count" => array('$sum' => 1))),
				array('$sort' => array("_id"=>-1)));
	
	//echo(json_encode($opt));
	
	$sortida = $collection->aggregate($opt);
	$swfirst=true;
	$valor=[];
	foreach ($sortida['result'] as $taula) {
		if ($swfirst == true) {
			$swfirst = false;
			array_push($valor,array("Tipo Frame","frames"));
		}
		array_push($valor, array(DescripcionFrame($taula['_id']),$taula['count']));
	}
	//Retornem el valor de la consulta.
	echo(json_encode($valor));
?>
