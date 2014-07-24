<?php
require_once('model.php');

#traer datos de un usuario

$new_sector_data=array(
	'sCveSector'=>'12',
	'sLocalidad'=>'San Rafael Rio Seco',
	'sMunicipio'=>'Amatlan de los Reyes',
	'sJurisdiccion'=>'X',
	'sEstado'=>'Veracruz1',
	'sRegionSanitaria'=>'1'
	);
$sector1 = new Sector();
print "AGREGAR USUARIO <BR><BR>USUARIO 1<br>";
$sector1->set($new_sector_data);
print $sector1->mensaje;
$sector1->get($new_sector_data['sCveSector'],$new_sector_data['sLocalidad']);
print '<BR>CLAVE: '.$sector1->sCveSector.'sLocalidad '.$sector1->sLocalidad. ' Municipio'.$sector1->sMunicipio.' sJurisdiccion '.$sector1->sJurisdiccion;
/*
$new_sector_data=array(
	'sCveSector'=>'13',
	'sLocalidad'=>'San Rafael Rio Seco',
	'sMunicipio'=>'Amatlan de los Reyes',
	'sJurisdiccion'=>'X',
	'sEstado'=>'Veracruz1',
	'sRegionSanitaria'=>'1'
	);
$sector2 = new Sector();
print "<BR><BR>USUARIO 2<br>";
$sector2->set($new_sector_data);
print $sector2->mensaje;
$sector2->get($new_sector_data['sCveSector'],$new_sector_data['sLocalidad']);
print "<BR>CLAVE: ".$sector2->sCveSector." sLocalidad ".$sector2->sLocalidad. " Municipio".$sector2->sMunicipio." sJurisdiccion ".$sector2->sJurisdiccion;

$new_sector_data=array(
	'sCveSector'=>'14',
	'sLocalidad'=>'San Rafael Rio Seco',
	'sMunicipio'=>'Amatlan de los Reyes',
	'sJurisdiccion'=>'X',
	'sEstado'=>'Veracruz1',
	'sRegionSanitaria'=>'1'
	);
$sector3 = new Sector();
print "<BR><BR>USUARIO 3<br>";
$sector3->set($new_sector_data);
print $sector3->mensaje;
$sector3->get($new_sector_data['sCveSector'],$new_sector_data['sLocalidad']);
print "<BR>CLAVE: ".$sector3->sCveSector." sLocalidad ".$sector3->sLocalidad. " Municipio".$sector3->sMunicipio." sJurisdiccion ".$sector3->sJurisdiccion;

print "<br><BR><BR>EDIT EDIT";

$new_sector_data=array(
	'sCveSector'=>'14',
	'sLocalidad'=>'San Rafael Rio Seco',
	'sMunicipio'=>'Amatlan',
	'sJurisdiccion'=>'10',
	'sEstado'=>'Veracruz',
	'sRegionSanitaria'=>'1'
	);
$sector5= new Sector();
$sector5->edit($new_sector_data);
print '<br>'.$sector5->mensaje;
$sector5->get($new_sector_data['sCveSector'],$new_sector_data['sLocalidad']);
print "<BR>CLAVE: ".$sector5->sCveSector." sLocalidad ".$sector5->sLocalidad. " Municipio".$sector5->sMunicipio." sJurisdiccion ".$sector5->sJurisdiccion;






print "<br><BR><BR>DELETE";
$sector5 = new Sector();
$sector5= new Sector();
$sector5->delete('12','San Rafael Rio Seco');
print '<br>'.$sector5->mensaje;
$sector6 = new Sector();
$sector6= new Sector();
$sector6->delete('13','San Rafael Rio Seco');
print '<br>'.$sector6->mensaje;
$sector7 = new Sector();
$sector7= new Sector();
$sector7->delete('14','San Rafael Rio Seco');
print '<br>'.$sector7->mensaje;










print "<br><BR><BR>GET  GET<br>";
$sector4 = new Sector();
$sector4->get('1','Orizaba');
print $sector4->mensaje;
print "<BR>CLAVE: ".$sector4->sCveSector." sLocalidad ".$sector4->sLocalidad. " Municipio".$sector4->sMunicipio." sJurisdiccion ".$sector4->sJurisdiccion;

print "<br><BR><BR>EDIT EDIT";

$new_sector_data=array(
	'sCveSector'=>'14',
	'sLocalidad'=>'San Rafael Rio Seco',
	'sMunicipio'=>'Amatlan de los Reyes',
	'sJurisdiccion'=>'10',
	'sEstado'=>'Veracruz',
	'sRegionSanitaria'=>'1'
	);
$sector5= new Sector();
$sector5->edit($new_sector_data);
print "<BR>CLAVE: ".$sector5->sCveSector." sLocalidad ".$sector5->sLocalidad. " Municipio".$sector5->sMunicipio." sJurisdiccion ".$sector5->sJurisdiccion;




*/
print "<br><BR><BR>IMPRIMIR TODOS";

$sector8= new Sector();
$sector8->get_AllSector('San Rafael Rio Seco');
print '<br>'.$sector8->mensaje;
print_r($sector8->rows);

?>
