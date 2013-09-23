<?php

	require_once("./rutinas.php");

	$collection = Coleccion("lbshistory");

	$query=[];
	// filtro por nodeMAC
	if (isset($_REQUEST["nodeMAC"])) {
		$nodeMAC=htmlspecialchars($_REQUEST["nodeMAC"]);
		$query=array_merge($query, array('nodeMAC' => "$nodeMAC"));
	}
	// Filtro por RSSI
	if (isset($_REQUEST["RSSI"])) {
		$RSSI=htmlspecialchars($_REQUEST["RSSI"]);
		$query=array_merge($query, array('RSSI' =>(int)$RSSI));
	}
	// Filtro de tiempo
	if (isset($_REQUEST["interval"])) {
		$TopTimestamp = FechaUltimaSenal($query, $collection);
		$time_ini=$TopTimestamp - ($_REQUEST["interval"] * 6000);
		$query=array_merge($query, array("SentTimestamp"=> array('$gt'=> $time_ini)));
	}
	
	
	// buscar registros dentro de la colección
	//$query = array('nodeMAC' => "$nodeMAC", 'RSSI' =>(int)$RSSI  );
	$sort= array('SentTimestamp'=>1 , 'FechaCaptura' => 1);
	$cursor = $collection->find($query)->sort($sort);
	
	$swfirst=true;
	$valor=[];
	foreach ($cursor as $taula) {
		if ($swfirst == true) {
			$swfirst = false;
			array_push($valor,array("Timestamp","FechaCaptura","fromMAC","toMAC", "RSSI", "TipoFrame", "DescFrame"));
		}
		$Timestamp=null;
		$FechaCaptura=null;
		$fromMAC=null;
		$toMAC=null;
		$RSSI=null;
		$TipoFrame=null;
		$DescFrame=null;
	
		if (isset($taula['SentTimestamp'])) {
			$Timestamp = toTimestamp($taula['SentTimestamp']);
		}
		if (isset($taula['FechaCaptura'])) {
			$FechaCaptura = toTimestamp($taula['FechaCaptura']);
		}
		if (isset($taula['fromMAC'])) {
			$fromMAC = $taula['fromMAC'];
		}
		if (isset($taula['toMAC'])) {
			$toMAC = $taula['toMAC'];
		}
		if (isset($taula['RSSI'])) {
			$RSSI = $taula['RSSI'];
		}
		if (isset($taula['TipoFrame'])) {
			$TipoFrame = $taula['TipoFrame'];
			$DescFrame = DescripcionFrame($TipoFrame);
		}
		array_push($valor, array($Timestamp, $FechaCaptura, $fromMAC,$toMAC, $RSSI." dBm", $TipoFrame, $DescFrame));
	}
	echo(json_encode($valor));
	
?>
