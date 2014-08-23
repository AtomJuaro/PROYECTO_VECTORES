<?
session_start();
echo "<br>RFC ".$_SESSION['sRfc']."<br>";
echo "<br>Nombre: ".$_SESSION['sNombre']."<br>";
echo "<br>Tipo Usuario : ".$_SESSION['sTipoUsuario']."<br>";
echo "<br><br>";
?>
<a href="/mvc/SESION/logout.php">CERRAR SESION</a>