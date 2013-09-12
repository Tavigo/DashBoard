<?php
	require_once("./lbshistory.php");

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
		$time_ini=time() - ($_REQUEST["interval"] * 60);
		$query=array_merge($query,  array("SentTimestamp"=> array('$gt'=> $time_ini * 1000)));
	}
	
	if ($swquery == true) {
		$sortida = $collection->distinct("$field", $query);
	} else {
		$sortida = $collection->distinct("$field");
	}
	
	echo(json_encode($sortida));
?>

