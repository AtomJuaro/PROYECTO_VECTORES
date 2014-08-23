<?php
session_start();
$Nombre=$_SESSION['sNombre'];
if($_SESSION['sTipoUsuario']=='Coordinador'||$_SESSION['sTipoUsuario']=='MASTER'){
	echo "
		<html>
			<head>
				<link rel='stylesheet' type='text/css' href='/mvc/site_media/css/ui.css'>
			</head>
			<body>
				<header>
					<section id='nuevo'>Cordinador del programa</section>
					<section id='nuevo'>Coordinador: ".$Nombre." <a href='/mvc/SESION/logout.php'>Cerrar Sesion</a></section>
				</header>
				<div id='contenedor'>
				<section id='fila'>
						<article name='usuarios' id='celda'><a href='/mvc/usuarios/'><img src='/mvc/site_media/img/usuarios.png'></a><label>Usuarios</label></article>
						<article name='sector' id='celda'><a href='/mvc/sector/'><img src='/mvc/site_media/img/sector.png'></a><label>Sectores</label></article>	
						<article name='brigada' id='celda'><a href='/mvc/brigada/'><img src='/mvc/site_media/img/brigada.png'></a><label>Brigadas</label></article>
				</section>
				<section id='fila'>
						<article name='equipo' id='celda'><a href='/mvc/equipo/'><img src='/mvc/site_media/img/equipo.png'></a><label>Equipo</label></article>
						<article name='cl1' id='celda'><img src='/mvc/site_media/img/cl1.png'><label>CL1</label></article>
						<article name='superviciones'id='celda'><img src='/mvc/site_media/img/superviciones.png'><label>Superviciones</label></article>
				</section>
				</section>
				</div>
				<div id='footer'>Copyright &copy; 2014 Jurisdiccion Sanitaria VII
				Desarrollado por <a href='https://twitter.com/AtomJuaro'>aj.romero@me.com</a> . All Rights Reserved.</div>
			</body>
		</html>
	";
}else{
	header("location:/mvc/site_media/html/access_denied.html");
}
?>
