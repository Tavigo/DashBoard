<?php
	require_once("./rutinas.php");	

	$collection = Coleccion("lbshistory");

	$field="";
	$swquery=false;
	$query=[];
	$sortida=[];
	
	if (isset($_REQUEST["field"])){
		$field=htmlspecialchars($_REQUEST["field"]);
	}
   
    // Si en las variables viene un filtro, montamos la 
    // consulta
    if (isset($_REQUEST["queryfield"]) && isset($_REQUEST["queryvalue"])) {
		$swquery= true;
		$query=array_merge($query,array(htmlspecialchars($_REQUEST["queryfield"]) => htmlspecialchars($_REQUEST["queryvalue"])));
	}
	// Si hay un intervalo, haremos un filtro con este intervalo
	if (isset($_REQUEST["interval"])) {
		$swquery=true;
		$TopTimestamp = FechaUltimaSenal($query, $collection);
		$time_ini=$TopTimestamp - ($_REQUEST["interval"] * 6000);
		$query=array_merge($query,  array("SentTimestamp"=> array('$gt'=> $time_ini)));
	}
	
	if ($swquery == true) {
		$sortida = $collection->distinct("$field", $query);
	} else {
		$sortida = $collection->distinct("$field");
	}
	
	echo(json_encode($sortida));
?>

