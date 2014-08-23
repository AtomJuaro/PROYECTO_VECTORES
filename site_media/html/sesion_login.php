<link rel="stylesheet" type="text/css" href="/mvc/site_media/css/login.css">
<span href="#" class="button" id="toggle-login">Control Larvario </span>
<div id="login">
  <div id="triangle"></div>
  <h1>Log in</h1>
  <form action="/mvc/sesion/iniciar/" method="POST" >
    <input type="text" placeholder="RFC" name="sRfc" required />
    <input type="password" placeholder="Password" name="sPassword" required/>
    <input type="submit" name="enviar" id="enviar" value="Log in" />
  </form>
</div>
<div id="footer">Copyright &copy; 2014 Jurisdiccion Sanitaria VII
Desarrollado por <a href="https://twitter.com/AtomJuaro">aj.romero@me.com</a> . All Rights Reserved.</div>