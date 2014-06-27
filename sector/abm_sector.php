<?php
require_once('sector_model.php');

#traer datos de un usuario
$sector1 = new Sector();
$sector1->get('1');
print 'TRAER SECTOR<BR>Localidad: '.$sector1->sLocalidad.' Municipio: '.$sector1->sMunicipio.'<br>';
print $sector1->mensaje.'<br>';

#crear nuevo usuario
$new_sector_data=array(
	'sCveSector'=>'2',
	'sLocalidad'=>'Zapata',
	'sMunicipio'=>'Orizaba',
	'sJurisdiccion'=>'11',
	'sEstado'=>'veracha',
	'sRegionSanitaria'=>'11'
);
$sector2= new Sector();
$sector2->set($new_sector_data);
$sector2->get($new_sector_data['sCveSector']);
print 'NUEVO SECTOR<BR>Localidad: '.$sector2->sLocalidad.' Municipio: '.$sector2->sMunicipio.' Jurisdiccion: '.$sector2->sJurisdiccion.' Ha sido creado <br>';


#editar usuario
$edit_sector_data=array(
	'sCveSector'=>'2',
	'sLocalidad'=>'Vive',
	'sMunicipio'=>'Cordoba',
	'sJurisdiccion'=>'11',
	'sEstado'=>'veracruz',
	'sRegionSanitaria'=>'11'
);
$sector3=new Sector();
$sector3->edit($edit_sector_data);
print 'estoy despues de editar';
$sector3->get($edit_sector_data['sCveSector']);
print 'DATOS EDITADOS <BR>Localidad: '.$sector3->sLocalidad.' Municipio: '. $sector3->sMunicipio .' Jurisduccion: '.$sector3->sJurisdiccion.' Ha sido modificado <br>';

#eliminar usuaro
$sector4=new Sector();
$sector4->get('2');
$sector4->delete('2');
print 'ELIMINAR<BR>Localidad: '.$sector3->sLocalidad.' Municipio: '. $sector3->sMunicipio .' Jurisduccion: '.$sector3->sJurisdiccion.' Ha sido eliminado <br>';

?>