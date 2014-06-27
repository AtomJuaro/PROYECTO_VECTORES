<?php
require_once('model.php');

#traer datos de un usuario
$usuario1 = new Usuario();
$usuario1->get('1111111111');
print 'GET<BR>'.$usuario1->sNombre.' '.$usuario1->sApePaterno.' Existe<br>';
print $usuario1->mensaje.'<br>';

#crear nuevo usuario
$new_user_data=array(
	'sRfc'=>'2222222',
	'sApeMaterno'=>'romero',
	'sApePaterno'=>'Juarez',
	'sNombre'=>'lucero',
	'sEmail'=>'luxy_juaro_1996@hotmail.com',
	'sPassword'=>'123123'
);
$usuario2= new Usuario();
$usuario2->set($new_user_data);
print $usuario2->mensaje.'<br>';
$usuario2->get($new_user_data['sRfc']);
print 'NUEVO USUARIO<BR>'.$usuario2->sNombre.' '.$usuario2->sApePaterno.' '.$usuario2->sEmail.' Ha sido creado <br>';


#editar usuario
$edit_user_data=array(
	'sRfc'=>'2222222',
	'sApeMaterno'=>'Romero',
	'sApePaterno'=>'J.',
	'sNombre'=>'luxy',
	'sEmail'=>'luxy@hotmail.com',
	'sTipoUsuario'=>'$sTipoUsuario',
	'sPassword'=>'123123'
);
$usuario3=new Usuario();
$usuario3->edit($edit_user_data);
print $usuario3->mensaje.'<br>';
$usuario3->get($edit_user_data['sRfc']);
print 'DATOS EDITADOS <BR>'.$usuario3->sNombre.' '. $usuario3->sApePaterno .' '.$usuario3->sEmail.' Ha sido modificado <br>';


/*#eliminar usuaro
$usuario4=new Usuario();
$usuario4->get('2222222');
$usuario4->delete('2222222');
print 'ELIMINAR<BR>'.$usuario4->sNombre . ' ' . $usuario4->sApePaterno . ' ha sido eliminado<br>';
print $usuario4->mensaje.'<br>';

*/
?>