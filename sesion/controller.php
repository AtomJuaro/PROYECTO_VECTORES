<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
    $event = VIEW_LOGIN;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(VIEW_LOGIN, VIEW_LOGOUT, VIEW_COORDINADOR, VALIDAR, SALIR);
    foreach ($peticiones as $peticion) {
        $uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true ) {
            $event = $peticion;
        }
    }
    session_start();
    $login_data = helper_login();
    $login = set_obj();
    //$_SESSION["sTipoUsuario"] ='';
    if(!isset($_SESSION['sRfc'])){
        switch ($event) {
            case VALIDAR:
                print "Validar";
                if($login->get($login_data['sRfc'], $login_data['sPassword'])){
                    $rows=array();
                    $rows=$login->get_rows();
                    $_SESSION["sRfc"] = $rows[0]['sRfc'];
                    $_SESSION["sNombre"] = $rows[0]['sNombre'];
                    $_SESSION["sTipoUsuario"] = $rows[0]['sTipoUsuario'];
                    if($_SESSION['sTipoUsuario']=='Coordinador'||$_SESSION['sTipoUsuario']=='MASTER'){
                    header("location:/mvc/SESION/sesion_coordinador.php");
                    }else if($_SESSION['sTipoUsuario']=='Aplicativo'){
                    header("location:/mvc/SESION/sesion_aplicativo.php");
                    }else{
                        header("location:/mvc/SESION/logout.php");
                    }
                }else{
                    retornar_vista(VIEW_LOGIN);
                    echo "<script>alert('No existen datos relacionados con RFC:  ".$login_data['sRfc']."');</script>";
                }
            
                break;
        case VIEW_LOGIN:
            retornar_vista(VIEW_LOGIN);
        }
    }else if($_SESSION['sTipoUsuario']=='Coordinador'||$_SESSION['sTipoUsuario']=='MASTER'){
    header("location:/mvc/SESION/sesion_coordinador.php");    
    }else if($_SESSION['sTipoUsuario']=='Aplicativo'){
      header("location:/mvc/SESION/sesion_aplicativo.php");    
    }else{
        //retornar_vista(VIEW_LOGIN); 
    }


}



function set_obj() {
    $obj = new Login();
    return $obj;
}

function helper_login() {
    $sector_data = array();
    if($_POST) {
        if(array_key_exists('sRfc', $_POST)) { 
            $sector_data['sRfc'] = $_POST['sRfc']; 
        }
        if(array_key_exists('sPassword', $_POST)) { 
            $sector_data['sPassword'] = $_POST['sPassword']; 
        }
    }
    return $sector_data;
}


handler();
?>
