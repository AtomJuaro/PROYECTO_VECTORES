<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler() {
if($_SESSION['sTipoUsuario']=='Coordinador'|| $_SESSION['sTipoUsuario']=='MASTER'){
    $event = VIEW_GET_SECTOR;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(SET_SECTOR, GET_SECTOR, DELETE_SECTOR, EDIT_SECTOR, ALL_SECTORES, TABLE_SECTORES,
                        VIEW_SET_SECTOR, VIEW_GET_SECTOR, VIEW_DELETE_SECTOR, 
                        VIEW_EDIT_SECTOR, VIEW_ALL_SECTORES, VIEW_TABLE_SECTORES);
    foreach ($peticiones as $peticion) {
        $uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true ) {
            $event = $peticion;
        }
    }

    $sector_data = helper_sector_data();

    $sector = set_obj();
    switch ($event) {
        case SET_SECTOR:
            $sector->set($sector_data);
            $data = array('mensaje'=>$sector->mensaje);
            retornar_vista(VIEW_SET_SECTOR, $data);
            echo "<script>alert('".$data['mensaje']."');</script>"; 
            break;
        case GET_SECTOR:
            //print_r($sector_data);
            $sector->get($sector_data['sCveSector'], $sector_data['sLocalidad']);
            $data = array(
                'sCveSector'=>$sector->sCveSector,
                'sLocalidad'=>$sector->sLocalidad,
                'sMunicipio'=>$sector->sMunicipio,
                'sJurisdiccion'=>$sector->sJurisdiccion,
                'sEstado'=>$sector->sEstado,
                'sRegionSanitaria'=>$sector->sRegionSanitaria,
                'mensaje'=>$sector->mensaje
            );
            if($data['mensaje']=='Sector no encontrado'){
            retornar_vista(VIEW_GET_SECTOR);
            echo "<script>alert('".$data['mensaje']."');</script>"; 
            break;
            }
            retornar_vista(VIEW_EDIT_SECTOR, $data);
            break;
        case DELETE_SECTOR:
            $sector->delete($sector_data['sCveSector'], $sector_data['sLocalidad']);
            $data = array('mensaje'=>$sector->mensaje);
            retornar_vista(VIEW_DELETE_SECTOR, $data);
            echo "<script>alert('".$data['mensaje']."');</script>"; 
            break;
        case EDIT_SECTOR:
            $sector->edit($sector_data);
            $data = array('mensaje'=>$sector->mensaje);
            retornar_vista(VIEW_GET_SECTOR, $data);
            echo "<script>alert('".$data['mensaje']."');</script>"; 
            break;
        case ALL_SECTORES:
            //print $sector_data;
            $sector->get_AllSector($sector_data['sLocalidad']);
            $rows=array();
            $rows=$sector->get_rows();
            retornar_vista_allSectores(VIEW_TABLE_SECTORES, $rows);
            break;
        default:
            retornar_vista($event);
    }
    }else{
    header("location:/mvc/site_media/html/access_denied.html");
}
}


function set_obj() {
    $obj = new Sector();
    return $obj;
}

function helper_sector_data() {
    $sector_data = array();
    if($_POST) {
        if(array_key_exists('sCveSector', $_POST)) { 
            $sector_data['sCveSector'] = $_POST['sCveSector']; 
        }
        if(array_key_exists('sLocalidad', $_POST)) { 
            $sector_data['sLocalidad'] = $_POST['sLocalidad']; 
        }
        if(array_key_exists('sMunicipio', $_POST)) { 
            $sector_data['sMunicipio'] = $_POST['sMunicipio']; 
        }
        if(array_key_exists('sJurisdiccion', $_POST)) { 
            $sector_data['sJurisdiccion'] = $_POST['sJurisdiccion']; 
        }
        if(array_key_exists('sEstado', $_POST)) { 
            $sector_data['sEstado'] = $_POST['sEstado']; 
        }
        if(array_key_exists('sRegionSanitaria', $_POST)) { 
            $sector_data['sRegionSanitaria'] = $_POST['sRegionSanitaria']; 
        }

    } else if($_GET) {
        if(array_key_exists('sCveSector', $_GET)) {
            $sector_data['sCveSector'] = $_GET['sCveSector'];
        }
        if(array_key_exists('sLocalidad', $_GET)) {
            $sector_data['sLocalidad'] = $_GET['sLocalidad'];
        }
    }
    return $sector_data;
}


handler();
?>
