<?php

	//$nodeMAC=htmlspecialchars($_GET["nodeMAC"]);
	
	
	//var_dump($_REQUEST);
	
	
	//echo "<br>".$_REQUEST['page'].".html?MAC=".$_REQUEST['MAC'];
	header( 'Location: '.$_REQUEST['page'].".html?MAC=".$_REQUEST['MAC'] ) ;

//switch($_SERVER['REQUEST_METHOD'])
//{
//case 'GET': $the_request = &$_GET; break;
//case 'POST': $the_request = &$_POST; break;
//.
//. // Etc.
//.
//default:
//}

?>
