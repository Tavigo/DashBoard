<?php

// Función para acceder a una colección de la base de datos
function Coleccion($nombrecoleccion) {
	// conectar a la base de datos
	$m = new MongoClient("5.56.58.76");
	//$m = new MongoClient("127.0.0.1");
	// seleccionar una base de datos
	$db = $m->lbs;
	// seleccionar una colección (equivalente a una tabla en una base de datos relacional)
	$collection = $db->$nombrecoleccion;
	
	return $collection;
}


// Función que retorna el TimeStamp de la última señal capturada por un NodeCapture
// de un MS
function FechaUltimaSenal($query, $collection) {
	
	// Montamos el orden de la colección
	$sort= array('SentTimestamp'=> -1);
	
	// Efectuamos la consulta
	$cursor = $collection->find($query)->sort($sort)->limit(1);
	
	$Timestamp=null;
	foreach ($cursor as $taula) {
		if (isset($taula['SentTimestamp'])) {
			$Timestamp = $taula['SentTimestamp'];
		}
	}
	
	//echo $Timestamp;
	
	return $Timestamp;
}

// Función que retorna la descripción de un tipo de frame dado el identificador
function DescripcionFrame($tipoFrame) {
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
	return htmlspecialchars(($descframe[strtoupper($tipoFrame)]));	
} 

// Función que retorna un timestamp en formato Y-m-d H:i:s
function toTimestamp($milliseconds) {
    $seconds = $milliseconds / 1000;
    $remainder = str_pad(round($seconds - ($seconds >> 0), 3) * 1000, 3,"0");
    return date('Y-m-d H:i:s.', $seconds).$remainder;
}


?>
