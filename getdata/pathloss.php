<?php

	$swfirst=true;
	$valor=[];
	for($i = 0.5; $i < 100; $i = $i+0.01) {
		if ($swfirst == true) {
			$swfirst = false;
			array_push($valor,array("Distancia","RSSI"));
		}
		$gain=10*log(pow((1.25/(4*pi()*$i)),2));
		array_push($valor, array(round($i,2),round($gain,0)));
	}
	//Retornem el valor de la consulta.
	echo(json_encode($valor));
?>
