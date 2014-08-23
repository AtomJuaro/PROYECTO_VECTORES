<?php
require_once('model.php');

//SET
$cl1 = new CL1();
$sRfc='APLI222222CAT';
$cl1_data=array(
	'CveBrigada'=>'2',
	'sRfc'=>$sRfc,
	'sOrden'=>'2', 
	'sDomicilio'=>'Calle 11111', 
	'sCveManzana'=>'15', 
	'bLote'=>'1', 
	'sCasa'=>'17', 
	'nRevisados'=>'3', 
	'nAbatizados'=>'4',
	'nEliminados'=>'5', 
	'nControlados'=>'6', 
	'nNoTratados'=>'7', 
	'nLarvicidaConsumido'=>'10', 
	'nVolumenTratado'=>'2', 
	'nHabitantes'=>'4'
	);
//print_r($cl1_data);
$cl1->delete_Datos($cl1_data);
//$cl1->get('2',$sRfc);
//$cl1->delete('2',$sRfc);
print $cl1->mensaje;
/*print '<br>'.$cl1->sOrden;
print '<br>'.$cl1->sDomicilio;*/
/*print '<br>'.$cl1->CveBrigada;
print '<br>'.$cl1->sRfc;
print $cl1->sObservaciones;//problema*/
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


// $brigada1->delete('5');
// print $brigada1->mensaje;
?>