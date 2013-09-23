	<?php

	require_once("./rutinas.php");
	
	$query=[];
	//Filtro de fromMAC
	if (isset($_REQUEST["fromMAC"])){
		$fromMAC=htmlspecialchars($_REQUEST["fromMAC"]);
		$query=array_merge($query, array("fromMAC"=>"$fromMAC"));
	}
	//Filtro por nodeMAC
	if (isset($_REQUEST["nodeMAC"])){
		$nodeMAC=htmlspecialchars($_REQUEST["nodeMAC"]);
		$query=array_merge($query, array("nodeMACS.nodeMAC"=>"$nodeMAC"));
	}
	
	$collection = Coleccion("lbsnodegroup");
	$sortida = $collection->findOne($query);
	echo(json_encode($sortida));
?>
