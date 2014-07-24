<?php
require_once('model.php');

//SET
$brigada1 = new Brigada();
/*$brigada_data=array(
	'CveBrigada'=>'5',
	'sCveSector'=>'1',
	'sLocalidad'=>'Orizaba',
	'dFecha'=>'2014-09-08',
	'sCiclo'=>'2',
	'sSemEpidemio'=>'2',
	'sEstrategia'=>'Barrido'
	);
$brigada1->set($brigada_data);
$brigada1->get('1');
print $brigada1->mensaje;
print $brigada1->CveBrigada.'<br>'.$brigada1->sCveSector.'<br>'.$brigada1->sLocalidad.'<br>'.$brigada1->dFecha.'<br>'.$brigada1->sCiclo.'<br>'.$brigada1->sSemEpidemio.'<br>'.$brigada1->sEstrategia;

$brigada1->get_by_date('2014-08-01', '2014-09-12');
print $brigada1->mensaje.'<br>';
$rows = array('');
$rows=$brigada1->get_rows();
print_r($rows);

$brigada_data=array(
	'CveBrigada'=>'5',
	'sCveSector'=>'1',
	'sLocalidad'=>'Orizaba',
	'dFecha'=>'2016-09-08',
	'sCiclo'=>'2',
	'sSemEpidemio'=>'2',
	'sEstrategia'=>'Tu puta madre'
	);

$brigada1->edit($brigada_data);
print $brigada1->mensaje.'<br>';
*/


$brigada1->delete('5');
print $brigada1->mensaje;
?>