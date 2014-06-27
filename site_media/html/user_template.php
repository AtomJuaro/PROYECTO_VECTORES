<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
  "http://www.w3.org/TR/html4/loose.dtd">
<html lang="es">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/mvc/site_media/css/base_template.css">
<title>ABM de Usuarios: {subtitulo}</title>
</head>

<body>
<div id="cabecera">
    <h1>Administrador de usuarios</h1>
    <h2>{subtitulo}</h2>
</div>
<div id="menu">
    <a href="/mvc/{VIEW_SET_USER}" title="Nuevo usuario">Agregar usuario</a>
    <a href="/mvc/{VIEW_GET_USER}" title="Buscar usuario">Buscar/editar usuario</a>
    <a href="/mvc/{VIEW_DELETE_USER}" title="Borrar usuario">Borrar usuario</a>
    <a href="/mvc/{VIEW_ALL_USERS}" title="Ver Todos">Ver Todos los Usuarios</a>
</div>
<div id="mensaje">
    {mensaje}
</div>
<div id="formulario">
    {formulario}
</div>

</body>

</html>
