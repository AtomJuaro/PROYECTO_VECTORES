<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('../sector/model.php');

function handler() {
    $event = VIEW_GET_SECTOR;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(SET_BRIGADA, GET_SECTOR, GET_BRIGADA, DELETE_BRIGADA, EDIT_BRIGADA, ALL_BRIGADAS, TABLE_BRIGADAS,
                        VIEW_SET_BRIGADA, VIEW_GET_SECTOR, VIEW_GET_BRIGADA, VIEW_DELETE_BRIGADA, 
                        VIEW_EDIT_BRIGADA, VIEW_ALL_BRIGADAS, VIEW_TABLE_BRIGADAS);
    foreach ($peticiones as $peticion) {
        $uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true ) {
            $event = $peticion;
        }
    }

    $brigada_data = helper_brigada_data();

    $brigada = obj_brigada();
    $sector =obj_sector();
    switch ($event) {
        case SET_BRIGADA:
        //////////////////////
            if (!array_key_exists('CveBrigada', $brigada_data)){
                retornar_vista(VIEW_SET_BRIGADA, $brigada_data);
                break;
            }else {
                $brigada->set($brigada_data);
                $data = array('mensaje'=>$brigada->mensaje);
                retornar_vista(VIEW_GET_SECTOR, $data);
                echo "<script>alert('".$data['mensaje']."');</script>"; 
                break;
            }
        case GET_SECTOR:
            ////////////////
            $sector->get_AllSector($brigada_data['sLocalidad']);
            $rows=array();
            $rows=$sector->get_rows();
            retornar_vista_allSectores(VIEW_TABLE_SECTORES, $rows);
            break;
        case GET_BRIGADA:
            ////////////////////////
            $brigada->get($brigada_data['CveBrigada']);
            $data = array(
                'CveBrigada'=>$brigada->CveBrigada,
                'sCveSector'=>$brigada->sCveSector,
                'sLocalidad'=>$brigada->sLocalidad,
                'dFecha'=>$brigada->dFecha,
                'sCiclo'=>$brigada->sCiclo,
                'sSemEpidemio'=>$brigada->sSemEpidemio,
                'sEstrategia'=>$brigada->sEstrategia,
                'mensaje'=>$brigada->mensaje
                );
            if($data['mensaje']=='Brigada no encontrada'){
            retornar_vista(VIEW_GET_BRIGADA);
            echo "<script>alert('".$data['mensaje']."');</script>"; 
            break;
            }
            retornar_vista(VIEW_EDIT_BRIGADA, $data);
            break;
        case DELETE_BRIGADA:
            ////////////////
            $brigada->delete($brigada_data['CveBrigada']);
            $data = array('mensaje'=>$brigada->mensaje);
            retornar_vista(VIEW_DELETE_BRIGADA, $data);
            echo "<script>alert('".$data['mensaje']."');</script>"; 
            break;
        case EDIT_BRIGADA:
            //////////////--------------
            $brigada->edit($brigada_data);
            $data = array('mensaje'=>$brigada->mensaje);
            retornar_vista(VIEW_GET_BRIGADA, $data);
            echo "<script>alert('".$data['mensaje']."');</script>"; 
            break;
        case ALL_BRIGADAS:
            //print $brigada_data;
            $brigada->get_by_date($brigada_data['fecha1'], $brigada_data['fecha2']);
            $rows=array();
            $rows=$brigada->get_rows();
            retornar_vista_allBrigadas(VIEW_TABLE_BRIGADAS, $rows);
            break;
        default:
            retornar_vista($event);
    }
}


function obj_brigada() {
    $obj = new Brigada();
    return $obj;
}
function obj_sector() {
    $obj = new Sector();
    return $obj;
}

function helper_brigada_data() {
    $brigada_data = array();
    if($_POST) {
        if(array_key_exists('CveBrigada', $_POST)) { 
            $brigada_data['CveBrigada'] = $_POST['CveBrigada']; 
        }
        if(array_key_exists('sCveSector', $_POST)) { 
            $brigada_data['sCveSector'] = $_POST['sCveSector']; 
        }
        if(array_key_exists('sLocalidad', $_POST)) { 
            $brigada_data['sLocalidad'] = $_POST['sLocalidad']; 
        }
        if(array_key_exists('dFecha', $_POST)) { 
            $brigada_data['dFecha'] = $_POST['dFecha']; 
        }
        if(array_key_exists('sCiclo', $_POST)) { 
            $brigada_data['sCiclo'] = $_POST['sCiclo']; 
        }
        if(array_key_exists('sSemEpidemio', $_POST)) { 
            $brigada_data['sSemEpidemio'] = $_POST['sSemEpidemio']; 
        }
        if(array_key_exists('sEstrategia', $_POST)) { 
            $brigada_data['sEstrategia'] = $_POST['sEstrategia']; 
        }

    } else if($_GET) {
        if(array_key_exists('sCveSector', $_GET)) {
            $brigada_data['sCveSector'] = $_GET['sCveSector'];
        }if(array_key_exists('sLocalidad', $_GET)){
            $brigada_data['sLocalidad'] = $_GET['sLocalidad'];
        }if(array_key_exists('CveBrigada', $_GET)){
            $brigada_data['CveBrigada'] = $_GET['CveBrigada'];
        }if(array_key_exists('fecha1', $_GET)){
            $brigada_data['fecha1'] = $_GET['fecha1'];
        }if(array_key_exists('fecha2', $_GET)){
            $brigada_data['fecha2'] = $_GET['fecha2'];
        }
    }
    return $brigada_data;
}


handler();
?>
