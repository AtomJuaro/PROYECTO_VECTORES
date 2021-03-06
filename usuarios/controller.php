<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler() {
if($_SESSION['sTipoUsuario']=='Coordinador'|| $_SESSION['sTipoUsuario']=='MASTER'){
    $event = VIEW_GET_USER;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(SET_USER, GET_USER, DELETE_USER, EDIT_USER, ALL_USERS, TABLE_USERS,
                        VIEW_SET_USER, VIEW_GET_USER, VIEW_DELETE_USER, 
                        VIEW_EDIT_USER, VIEW_ALL_USERS, VIEW_TABLE_USERS);
    foreach ($peticiones as $peticion) {
        $uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true ) {
            $event = $peticion;
        }
    }

    $user_data = helper_user_data();
    $usuario = set_obj();
    switch ($event) {
        case SET_USER:
            $usuario->set($user_data);
            $data = array('mensaje'=>$usuario->mensaje);
            retornar_vista(VIEW_SET_USER, $data);
            echo "<script>alert('".$data['mensaje']."');</script>"; 
            break;
        case GET_USER:
            $usuario->get($user_data);
            $data = array(
                'sRfc'=>$usuario->sRfc,
                'sApePaterno'=>$usuario->sApePaterno,
                'sApeMaterno'=>$usuario->sApeMaterno,
                'sNombre'=>$usuario->sNombre,
                'sEmail'=>$usuario->sEmail,
                'sPassword'=>$usuario->sPassword,
                'sTipoUsuario'=>$usuario->sTipoUsuario,
                'mensaje'=>$usuario->mensaje
            );
            if($data['mensaje']=='Usuario no encontrado'){
            retornar_vista(VIEW_GET_USER);
            echo "<script>alert('".$data['mensaje']."');</script>"; 
            break;
            }
            retornar_vista(VIEW_EDIT_USER, $data);
            break;
        case DELETE_USER:
            $usuario->delete($user_data['sRfc']);
            $data = array('mensaje'=>$usuario->mensaje);
            retornar_vista(VIEW_DELETE_USER, $data);
            echo "<script>alert('".$data['mensaje']."');</script>"; 
            break;
        case EDIT_USER:
            $usuario->edit($user_data);
            $data = array('mensaje'=>$usuario->mensaje);
            retornar_vista(VIEW_GET_USER, $data);
            echo "<script>alert('".$data['mensaje']."');</script>"; 
            break;
        case ALL_USERS:
            //print $user_data;
            $usuario->get_AllUsers($user_data);
            $rows=array();
            $rows=$usuario->get_rows();
            retornar_vista_allUsers(VIEW_TABLE_USERS, $rows);
            break;
        default:
            retornar_vista($event);
    }
}else{
    header("location:/mvc/site_media/html/access_denied.html");
}
}


function set_obj() {
    $obj = new Usuario();
    return $obj;
}

function helper_user_data() {
    $user_data = array();
    if($_POST) {
        if(array_key_exists('sRfc', $_POST)) { 
            $user_data['sRfc'] = $_POST['sRfc']; 
        }
        if(array_key_exists('sApePaterno', $_POST)) { 
            $user_data['sApePaterno'] = $_POST['sApePaterno']; 
        }
        if(array_key_exists('sApeMaterno', $_POST)) { 
            $user_data['sApeMaterno'] = $_POST['sApeMaterno']; 
        }
        if(array_key_exists('sNombre', $_POST)) { 
            $user_data['sNombre'] = $_POST['sNombre']; 
        }
        if(array_key_exists('sEmail', $_POST)) { 
            $user_data['sEmail'] = $_POST['sEmail']; 
        }
        if(array_key_exists('sTipoUsuario', $_POST)) { 
            $user_data['sTipoUsuario'] = $_POST['sTipoUsuario']; 
        }
        if(array_key_exists('sPassword', $_POST)) { 
            $user_data['sPassword'] = $_POST['sPassword']; 
        }

    } else if($_GET) {
        if(array_key_exists('sRfc', $_GET)) {
            $user_data = $_GET['sRfc'];
        }if(array_key_exists('sTipoUsuario', $_GET))
            $user_data = $_GET['sTipoUsuario'];
    }
    return $user_data;
}


handler();
?>
