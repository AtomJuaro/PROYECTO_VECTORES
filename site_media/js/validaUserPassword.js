<script> 
function  validarPasswd(){
var p1 = document.getElementById("sPassword").value;
var p2 = document.getElementById("sPasswordB").value;
if (p1 != p2) {
  alert("Las contraseñas deben coincidir");
  return false;
} else {
  alert("Usuario Agregado");
  return true;
}
}
</script>