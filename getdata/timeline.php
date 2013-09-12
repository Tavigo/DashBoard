<?php

	require_once("./lbshistory.php");
	
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
		$time_ini=time() - ($_REQUEST["interval"] * 60);
		$query=array_merge($query, array("SentTimestamp"=> array('$gt'=> $time_ini * 1000)));
	}
	
	
	// buscar registros dentro de la colección
	$sort= array('SentTimestamp'=>1);
	$cursor = $collection->find($query)->sort($sort);
	
	$swfirst=true;
	$valor=[];
	foreach ($cursor as $taula) {
		if ($swfirst == true) {
			$swfirst = false;
			array_push($valor,array("Timestamp", "RSSI"));
		}
		$Timestamp=null;
		$RSSI=null;
		if (isset($taula['SentTimestamp'])) {
			$Timestamp = toTimestamp($taula['SentTimestamp']);
		}
		if (isset($taula['RSSI'])) {
			$RSSI = $taula['RSSI'];
		}
		
		array_push($valor, array($Timestamp, $RSSI));
	}
	echo(json_encode($valor));


function toTimestamp($milliseconds) {
    $seconds = $milliseconds / 1000;
    $remainder = str_pad(round($seconds - ($seconds >> 0), 3) * 1000, 3,"0");
    return date('Y-m-d H:i:s.', $seconds).$remainder;
}
?>
