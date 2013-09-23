<?php
	require_once("./rutinas.php");
	
	$collection = Coleccion("lbsRSSIavg");
		
	$query=[];
	// filtro por nodeMAC
	if (isset($_REQUEST["nodeMAC"])) {
		$nodeMAC=htmlspecialchars($_REQUEST["nodeMAC"]);
		$query=array_merge($query, array('nodeMAC' => "$nodeMAC"));
	}
	// Filtro por RSSI
	if (isset($_REQUEST["fromMAC"])) {
		$fromMAC=htmlspecialchars($_REQUEST["fromMAC"]);
		$query=array_merge($query, array('fromMAC' => "$fromMAC"));
	}
	// Filtro de tiempo
	if (isset($_REQUEST["interval"])) {
		$TopTimestamp = FechaUltimaSenal($query, $collection);
		$time_ini=$TopTimestamp - ($_REQUEST["interval"] * 6000);
		$query=array_merge($query, array("SentTimestamp"=> array('$gt'=> $time_ini)));
	}
	
	
	// buscar registros dentro de la colección
	$sort= array('SentTimestamp'=>1);
	$cursor = $collection->find($query)->sort($sort);
	
	//echo(json_encode($query));
	
	$swfirst=true;
	$valor=[];
	foreach ($cursor as $taula) {
		if ($swfirst == true) {
			$swfirst = false;
			array_push($valor,array("Timestamp", "RSSI", "RSSIavg"));
		}
		$Timestamp=null;
		$RSSI=null;
		$RSSIavg=null;
		if (isset($taula['SentTimestamp'])) {
			$Timestamp = toTimestamp($taula['SentTimestamp']);
		}
		if (isset($taula['RSSI'])) {
			$RSSI = $taula['RSSI'];
		}
		if (isset($taula['RSSIavg'])) {
			$RSSIavg = $taula['RSSIavg'];
		}
		array_push($valor, array($Timestamp, $RSSI, $RSSIavg));
		//array_push($valor, array($Timestamp, $RSSI));
	}
	echo(json_encode($valor));

?>
