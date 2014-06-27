<?php
require_once('brigada_model.php');

//SET
$brigada1 = new Brigada();

$brigada1->query= "SELECT CURDATE()";
$date=$brigada1->execute_single_query_whit_resut();
$brigada_data=array(
	'CveBrigada'=>'',
	'sCveSector'=>'1',
	'dFecha'=>'$date',
	'sCiclo'=>'2',
	'sSemEpidemio'=>'2',
	'sEstrategia'=>'Barrido'
	);
$brigada1->set($brigada_data);
print $brigada1->mensaje;
?>