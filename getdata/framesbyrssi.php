<?php
	require_once("./lbshistory.php");

// Descripción de los diferentes tipos de frames en una comunicación WIFI
$descframe=[
  '00'=>'Association Request',
  '10'=>'Association Response',
  '20'=>'Reassociation Request',
  '30'=>'Reassociation Response',
  '40'=>'Probe Request',
  '50'=>'Probe Response',
  '80'=>'Beacon',
  '90'=>'Announcement traffic indication message',
  'A0'=>'Disassociation',
  'B0'=>'Authentication',
  'C0'=>'Deauthentication',
  'D0'=>'Action (for spectrum management with 802.11h, also QoS)',
  '84'=>'Block Acknowledgment Request (QoS)',
  '94'=>'Block Acknowledgment (QoS)',
  'A4'=>'Power Save (PS)-Poll',
  'B4'=>'RTS',
  'C4'=>'CTS',
  'D4'=>'Acknowledgment (ACK)',
  'E4'=>'Contention-Free (CF-End)',
  'F4'=>'CF-End + CF-Ack',
  '08'=>'Data',
  '28'=>'Data + CF-Ack',
  '38'=>'Data +CF-Ack-CF-Poll',
  '48'=>'Null data (no data transmitted)',
  '58'=>'CF-Ack (no data transmitted)',
  '68'=>'CF-Poll (no data transmitted)',
  '78'=>'CF-Ack+CF-Poll (no data transmitted)',
  '88'=>'QoS Data',
  '98'=>'QoS Data + CF-Ack',
  'A8'=>'QoS Data + CF-Poll',
  'C8'=>'QoS Null (no data transmitted)',
  'D8'=>'QoS CF-Ack (no data transmitted)',
  'E8'=>'QoS CF-Poll (no data trasnmitted)',
  'F8'=>'QoS CF-Ack+CF-Poll(no data transmitted)'
];


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
		$time_ini=time() - ($_REQUEST["interval"] * 60);
		$query=array_merge($query, array("SentTimestamp"=> array('$gt'=> $time_ini * 1000)));
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
		if (isset($taula['TipoFrame'])) {
			$TipoFrame = $taula['TipoFrame'];
			$DescFrame = htmlspecialchars($descframe[strtoupper($taula['TipoFrame'])]);
		}
		array_push($valor, array($Timestamp, $FechaCaptura, $fromMAC,$toMAC, $RSSI." dBm", $TipoFrame, $DescFrame));
	}
	echo(json_encode($valor));


function toTimestamp($milliseconds) {
    $seconds = $milliseconds / 1000;
    $remainder = str_pad(round($seconds - ($seconds >> 0), 3) * 1000, 3,"0");
    return date('Y-m-d H:i:s.', $seconds).$remainder;
}
	
	
	
?>
