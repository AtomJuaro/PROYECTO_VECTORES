<?php
session_start();
$Nombre=$_SESSION['sNombre'];
if($_SESSION['sTipoUsuario']=='Aplicativo'){
	echo "
		<html>
			<head>
				<link rel='stylesheet' type='text/css' href='/mvc/site_media/css/ui.css'>
			</head>
			<body>
				<header>
					<section id='nuevo'>Aplicativo</section>
					<section id='nuevo'>Aplicativo: ".$Nombre." <a href='/mvc/SESION/logout.php'>Cerrar Sesion</a></section>
				</header>
				<div id='contenedor'>
				<section id='fila'>
						<center>
						<article name='cl1' id='celda'><a href='/mvc/CL1/'><img src='/mvc/site_media/img/cl1.png'></a><br><label>Administrar CL1</label></article>
						</center>
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
