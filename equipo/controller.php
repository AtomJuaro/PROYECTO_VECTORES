<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('../brigada/model.php');
require_once('../usuarios/model.php');

function handler() {
if($_SESSION['sTipoUsuario']=='Coordinador'|| $_SESSION['sTipoUsuario']=='MASTER'){
    $event = VIEW_GET_EQUIPO;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(SET_EQUIPO, GET_EQUIPO, GET_BRIGADA, GET_JEFE, SET_JEFE, DELETE_EQUIPO, DELETE_USER, EDIT_EQUIPO, EDIT_JEFE, EDIT_APLICATIVO, ALL_EQUIPO, GET_JEFESECTOR, SET_JEFESECTOR,
                        GET_APLICATIVO, DELETE_USER, SET_APLICATIVO, VIEW_TABLE_APLICATIVO, VIEW_EDIT_EQUIPO, VIEW_TABLE_EQUIPO, VIEW_ALL_EQUIPO, VIEW_TABLE_JEFESECTOR,
                        VIEW_SET_EQUIPO, VIEW_GET_EQUIPO, VIEW_GET_BRIGADA, VIEW_DELETE_EQUIPO, VIEW_TABLE_JEFE, VIEW_TABLE_EDITJEFE, VIEW_TABLE_ALLEQUIPO
                        );
    foreach ($peticiones as $peticion) {
        $uri_peticion = EQUIPO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true ) {
            $event = $peticion;
        }
    }

    $equipo_data = helper_equipo_data();
    $index='';
    $equipo = set_equipo();
    $CveBrigada='0';
    switch ($event) {
        case GET_BRIGADA:
        
            $equipo->brigada_by_estado($equipo_data);
            $rows=array();
            $rows=$equipo->get_rows();
            retornar_vista_allBrigadas(VIEW_TABLE_BRIGADAS, $rows);
            break;
        case GET_JEFESECTOR:
            //print_r($equipo_data);

            $equipo->get_Users($equipo_data['sTipoUsuario']);
            $rows=array();
            $rows=$equipo->get_rows();
            //$rows=array_merge((array)$rows, (array)$equipo_data);
            $rows[]['CveBrigada']=$equipo_data['CveBrigada'];
            //print '<br>ROWS:';
            //print_r($rows);
            retornar_vista_allUsers(VIEW_TABLE_JEFESECTOR,$rows);
            break;
        case SET_JEFESECTOR:
            //print_r($equipo_data);
            $equipo->set($equipo_data['CveBrigada'], $equipo_data['sRfc']);
            $mensaje=$equipo->mensaje;
            goto GET_JEFE;
            break;
        case GET_JEFE:
            GET_JEFE:
            $equipo->get_AllUsers($equipo_data['sTipoUsuario']);
            $rows=array();
            $rows=$equipo->get_rows();
            $rows[]['CveBrigada']=$equipo_data['CveBrigada'];
            if($index=='editJefe'){
                $rows[]['sRfc2']=$equipo_data['sRfc'];
                retornar_vista_allUsers(VIEW_TABLE_EDITJEFE, $rows);
            }else{
            retornar_vista_allUsers(VIEW_TABLE_JEFE, $rows); 
            }
            break;
        case SET_JEFE:
            $equipo->set($equipo_data['CveBrigada'], $equipo_data['sRfc']);
            $mensaje=$equipo->mensaje;
            goto GET_APLICATIVO;
            break;
        case GET_APLICATIVO:
            GET_APLICATIVO:
            $equipo->get_AllUsers($equipo_data['sTipoUsuario']);
            $rows=array();
            $rows=$equipo->get_rows();
            $rows[]['CveBrigada']=$equipo_data['CveBrigada'];
            if($index=='editAplicativo'){
                $rows[]['sRfc2']=$equipo_data['sRfc'];
                retornar_vista_allUsers(VIEW_TABLE_EDITAPLICATIVO, $rows);
            }else if($index=='addAplicativo'){
                retornar_vista_allUsers(VIEW_TABLE_EDITAPLICATIVO, $rows);
            }else{
            retornar_vista_allUsers(VIEW_TABLE_APLICATIVO, $rows);
            echo "<script>alert('".$mensaje."".$equipo_data['sRfc']."');</script>"; 
            }
            break;
        case SET_APLICATIVO:
            for ($i=0;$i<count($equipo_data['sRfc']);$i++){
                $equipo->set($equipo_data['CveBrigada'], $equipo_data['sRfc'][$i]);
            }
            $mensaje=$equipo->mensaje;
            retornar_vista(VIEW_GET_BRIGADA);
            echo "<script>alert('".$mensaje."');</script>"; 
            break;
        case GET_EQUIPO:
            GET_EQUIPO:
            //print $equipo_data['CveBrigada'];
            $equipo->get($equipo_data['CveBrigada']);
            $rows=array();
            $rows=$equipo->get_rows();
            //print_r($rows);
            //$rows[]['CveBrigada']=$equipo_data;
            $mensaje=$equipo->mensaje;
            if($mensaje=='Equipo no encontrado'){
                retornar_vista(VIEW_GET_EQUIPO);
                echo "<script>alert('".$mensaje."');</script>"; 
                break;
            }
            retornar_vista_allUsers(VIEW_TABLE_EQUIPO, $rows);
            break;
        case DELETE_USER:
            //print_r($equipo_data);
            if($equipo_data['sTipoUsuario']=='JefeBrigada'||$equipo_data['sTipoUsuario']=='JefeSector'){
                echo "<script>alert('No es posible eliminar al usuario seleccionado');</script>"; 
                goto GET_EQUIPO;
            }else{
                $equipo->delete($equipo_data['sRfc']);
                echo "<script>alert(' Se ha eliminado el usuario con RFC".$equipo_data['sRfc']."');</script>"; 
                goto GET_EQUIPO;
            }
            break;
        case EDIT_EQUIPO:
            if($equipo_data['sTipoUsuario']=='JefeBrigada'){
                $index='editJefe';
                goto GET_JEFE;
            }else if($equipo_data['sTipoUsuario']=='Aplicativo' && !array_key_exists('sRfc', $equipo_data)){
                $index='addAplicativo';
                goto GET_APLICATIVO;
            }else{  
            $index='editAplicativo';
            goto GET_APLICATIVO;
            }
            break;
        case EDIT_JEFE:
            $equipo->delete($equipo_data['sRfc2']);
            $equipo->set($equipo_data['CveBrigada'], $equipo_data['sRfc']);
            $mensaje=$equipo->mensaje;
            goto GET_EQUIPO;
            echo "<script>alert('".$mensaje."');</script>"; 
        case EDIT_APLICATIVO:
            $equipo->delete($equipo_data['sRfc2']);
            $equipo->set($equipo_data['CveBrigada'], $equipo_data['sRfc']);
            $mensaje=$equipo->mensaje;
            goto GET_EQUIPO;
            echo "<script>alert('".$mensaje."');</script>"; 
            break;
        case DELETE_EQUIPO:
             $equipo->delete_Equipo($equipo_data);
             $mensaje=$equipo->mensaje;
             retornar_vista(VIEW_GET_EQUIPO);
            echo "<script>alert('".$mensaje."');</script>"; 
            break;
        case ALL_EQUIPO:
            //print_r($equipo_data);
            $equipo->get_AllEquipos($equipo_data);
            $rows=array();
            $rows=$equipo->get_rows();
            retornar_vista_allUsers(VIEW_TABLE_ALLEQUIPO, $rows);
            break;
        default:
            retornar_vista($event);
    }
    }else{
    header("location:/mvc/site_media/html/access_denied.html");
}
}


function set_equipo() {
    $obj = new EquipoBrigada();
    return $obj;
}
function set_brigada(){
    $obj = new Brigada();
    return $obj;
}
function set_usuario(){
    $obj=new Usuario();
    return $obj;
}

function helper_equipo_data() {
    $equipo_data = array();
    if($_POST) {
        if(array_key_exists('CveBrigada', $_POST)) { 
            $equipo_data['CveBrigada'] = $_POST['CveBrigada']; 
        }if(array_key_exists('sRfc', $_POST)) { 
            $equipo_data['sRfc'] = $_POST['sRfc']; 
        }if(array_key_exists('sTipoUsuario', $_POST)) { 
            $equipo_data['sTipoUsuario'] = $_POST['sTipoUsuario']; 
        }if(array_key_exists('sRfc2', $_POST)) { 
            $equipo_data['sRfc2'] = $_POST['sRfc2']; 
        }
    } else if($_GET) {
        if(array_key_exists('CveBrigada', $_GET)) {
            $equipo_data = $_GET['CveBrigada'];
        }if(array_key_exists('sRfc', $_GET))
            $equipo_data = $_GET['sRfc'];
        }if(array_key_exists('sEstado', $_GET))
            $equipo_data = $_GET['sEstado'];
    return $equipo_data;
}


handler();
?>
