<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');
require_once('../equipo/model.php');

function handler() {
if($_SESSION['sTipoUsuario']=='Aplicativo'){
    $event = VIEW_GET_BRIGADA;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(SET_CL1, GET_CL1, DELETE_CL1, EDIT_CL1, EDIT_OBS, TABLE_CL1, GET_BRIGADA, GET_CL1_CABECERA, GET_CL1_DATA, SET_CL1_DATA, SET_DATA, GET_DATA, SET_FILA, DELETE,
                        VIEW_SET_CL1, VIEW_GET_CL1, VIEW_DELETE_CL1, VIEW_EDIT_CL1, VIEW_ALL_CL1, VIEW_TABLE_CL1, VIEW_GET_CL1_DATA, VIEW_GET_BRIGADA, VIEW_TABLE_BRIGADAS,
                        VIEW_GET_DATA, VIEW_SET_DATA,
                        );
    foreach ($peticiones as $peticion) {
        $uri_peticion = MODULO.$peticion.'/';
        if( strpos($uri, $uri_peticion) == true ) {
            $event = $peticion;
        }
    }
    $sRfcAplicativo = $_SESSION['sRfc'];
    $cl1_data = helper_cl1_data();
    $flag='';
    $cl1 = obj_cl1();
    $cluno= cl1();
    $equipo =obj_equipo();
    switch ($event) {
        case GET_BRIGADA:
            $cl1->getBrigadaCL1($sRfcAplicativo);
            $rows=array();
            $rows=$cl1->get_rows();
            retornar_vista_allBrigadas(VIEW_TABLE_BRIGADAS, $rows);
            break;
        case SET_CL1:
            $data=array(
                'sRfc'=>$sRfcAplicativo,
                'CveBrigada'=>$cl1_data['CveBrigada'],
                'sObservaciones'=>''
                );
            $cl1->set($data);
            echo "<script>alert('".$cl1->mensaje."');</script>";
            $flag='set';
            goto GET_CL1_CABECERA;
            break;
        case GET_CL1_CABECERA:
            GET_CL1_CABECERA:
            $cluno->get_datosCl1($cl1_data['CveBrigada']);
            $cluno->get_jefe('JefeSector',$cl1_data['CveBrigada']);
            $cluno->get_jefe('JefeBrigada',$cl1_data['CveBrigada']);
            $rows=array();
            $resultado=array();
            $rows=$cluno->get_rows();
            $sRfcJefeSector=$rows['1']['sRfc'];
            $sRfcJefeBrigada=$rows['2']['sRfc'];
            $resultado=$rows['0'];
            $resultado['sRfcJefeSector']=$sRfcJefeSector;
            $resultado['sRfcJefeBrigada']=$sRfcJefeBrigada;
            $resultado['sRfcAplicativo']=$sRfcAplicativo;
            $resultado['CveBrigada']=$cl1_data['CveBrigada'];
            if($flag=='set'){
                retornar_vista(VIEW_SET_CL1,$resultado);
            }else{
                $obj=obj_cl1();
                $obj->get_Datos($cl1_data['CveBrigada'], $sRfcAplicativo);
                $obj2=obj_cl1();
                $obj2->getObservaciones($sRfcAplicativo, $cl1_data['CveBrigada']);
                $resultado=array_merge($resultado, $obj2->get_rows(), $obj->get_rows());
                retornar_vista_tablaCL1(VIEW_EDIT_CL1, $resultado);
            }
            break;
        case GET_CL1:
            $cl1->get($sRfcAplicativo);
            $rows=$cl1->get_rows();
            retornar_vista_allBrigadas(VIEW_TABLE_CL1, $rows);
            break;
        case SET_CL1_DATA:
            $n='1';
            $mensaje='';
                //print_r($cl1_data);
                for($i=1; $i<(count($cl1_data, COUNT_RECURSIVE)/count($cl1_data))-1; $i++){
                    $data=array(
                        'CveBrigada'=>$cl1_data['CveBrigada'][$i],
                        'sRfc'=>$sRfcAplicativo,
                        'sDomicilio'=>$cl1_data['sDomicilio'][$i],
                        'sCveSector'=>$cl1_data['sCveSector'][$i],
                        'sCveManzana'=>$cl1_data['sCveManzana'][$i],
                        'bLote'=>$cl1_data['bLote'][$i],
                        'sCasa'=>$cl1_data['sCasa'][$i],
                        'nRevisados'=>$cl1_data['nRevisados'][$i],
                        'nAbatizados'=>$cl1_data['nAbatizados'][$i],
                        'nEliminados'=>$cl1_data['nEliminados'][$i],
                        'nControlados'=>$cl1_data['nControlados'][$i],
                        'nNoTratados'=>$cl1_data['nNoTratados'][$i],
                        'nLarvicidaConsumido'=>$cl1_data['nLarvicidaConsumido'][$i],
                        'nVolumenTratado'=>$cl1_data['nVolumenTratado'][$i],
                        'nHabitantes'=>$cl1_data['nHabitantes'][$i],
                    );
                    if($data['sDomicilio']!='' && $data['sCveManzana']!=''){
                        $data['sOrden']=$n;
                        $n++;
                        $cl1->set_Datos($data);
                        $mensaje.=$cl1->mensaje.'\n';
                    }
                }
                $datos_edit=array(
                    'sRfc'=>$sRfcAplicativo,
                    'CveBrigada'=>$cl1_data['CveBrigada']['1'],
                    'sObservaciones'=>$cl1_data['sObservaciones']   
                    );
                $cl1->edit($datos_edit);
                if($mensaje==''){
                    $mensaje='No se guardo ningun dato del formulario, para completarlo vaya a la seccion de Editar CL1';
                }
                echo "<script>alert('".$mensaje."');</script>";
                retornar_vista(VIEW_GET_BRIGADA);
                break;
        case GET_DATA:
            $cl1->getFila($sRfcAplicativo, $cl1_data['CveBrigada'], $cl1_data['sOrden']);
            $rows=array();
            $rows=$cl1->get_rows();
            $rows['sCveSector']=$cl1_data['sCveSector'];
            $rows['CveBrigada']=$cl1_data['CveBrigada'];
            retornar_vista(VIEW_GET_DATA, $rows);
            
            break;
        case SET_DATA:
            $cl1_data['sOrden']=$cl1_data['sOrden']+1;
            retornar_vista(VIEW_SET_DATA,$cl1_data);
            break;
        case SET_FILA:
            $data=array(
                'sOrden'=>$cl1_data['sOrden'],
                'CveBrigada'=>$cl1_data['CveBrigada'],
                'sRfc'=>$sRfcAplicativo,
                'sDomicilio'=>$cl1_data['sDomicilio'],
                'sCveSector'=>$cl1_data['sCveSector'],
                'sCveManzana'=>$cl1_data['sCveManzana'],
                'bLote'=>$cl1_data['bLote'],
                'sCasa'=>$cl1_data['sCasa'],
                'nRevisados'=>$cl1_data['nRevisados'],
                'nAbatizados'=>$cl1_data['nAbatizados'],
                'nEliminados'=>$cl1_data['nEliminados'],
                'nControlados'=>$cl1_data['nControlados'],
                'nNoTratados'=>$cl1_data['nNoTratados'],
                'nLarvicidaConsumido'=>$cl1_data['nLarvicidaConsumido'],
                'nVolumenTratado'=>$cl1_data['nVolumenTratado'],
                'nHabitantes'=>$cl1_data['nHabitantes']
                );
            $cl1->set_Datos($data);
            $mensaje=$cl1->mensaje;
            echo "<script>alert('".$mensaje."');</script>";
            goto GET_CL1_CABECERA;
            break;
        case DELETE_CL1:
            $cl1_data['sRfc']=$sRfcAplicativo;
            $cl1->delete_Datos($cl1_data);
            echo "<script>alert('".$cl1->mensaje."');</script>";            
            goto GET_CL1_CABECERA;
            break;
        case EDIT_CL1:
            $data=array(
                'sOeden'=>$cl1_data['sOrden'],
                'sRfc'=>$sRfcAplicativo,
                'CveBrigada'=>$cl1_data['CveBrigada'],
                'sDomicilio'=>$cl1_data['sDomicilio'],
                'sOrden'=>$cl1_data['sOrden'],
                'sCveManzana'=>$cl1_data['sCveManzana'],
                'bLote'=>$cl1_data['bLote'],
                'sCasa'=>$cl1_data['sCasa'],
                'nRevisados'=>$cl1_data['nRevisados'],
                'nAbatizados'=>$cl1_data['nAbatizados'],
                'nEliminados'=>$cl1_data['nEliminados'],
                'nControlados'=>$cl1_data['nControlados'],
                'nNoTratados'=>$cl1_data['nNoTratados'],
                'nLarvicidaConsumido'=>$cl1_data['nLarvicidaConsumido'],
                'nVolumenTratado'=>$cl1_data['nVolumenTratado'],
                'nHabitantes'=>$cl1_data['nHabitantes']
                );
            $cl1_data=array(
                'CveBrigada'=>$data['CveBrigada']
                );
            $cl1->edit_Datos($data);
            echo "<script>alert('".$cl1->mensaje."');</script>";
            goto GET_CL1_CABECERA;
           break;
        case EDIT_OBS:
            $cl1_data['sRfc']=$sRfcAplicativo;
            $cl1->edit($cl1_data);
            $mensaje=$cl1->mensaje;
            echo "<script>alert('".$mensaje."');</script>";    
            retornar_vista(VIEW_GET_BRIGADA);            
            break;
        case DELETE:
            $cl1->delete($cl1_data['CveBrigada'], $sRfcAplicativo);
            echo "<script>alert('".$cl1->mensaje."');</script>";
            retornar_vista(VIEW_GET_BRIGADA);            
            break;
        default:
            retornar_vista($event);
    }
    }else{
    header("location:/mvc/site_media/html/access_denied.html");
}
}


function obj_cl1() {
    $obj = new CL1();
    return $obj;
}
function cl1() {
    $obj = new CL1();
    return $obj;
}
function obj_equipo() {
    $obj = new EquipoBrigada();
    return $obj;
}

function helper_cl1_data() {
    $cl1_data = array();
    if($_POST) {
        if(array_key_exists('CveBrigada', $_POST)) { 
            $cl1_data['CveBrigada'] = $_POST['CveBrigada']; 
        }if(array_key_exists('sDomicilio', $_POST)) { 
            $cl1_data['sDomicilio'] = $_POST['sDomicilio']; 
        }if(array_key_exists('sOrden', $_POST)) { 
            $cl1_data['sOrden'] = $_POST['sOrden']; 
        }if(array_key_exists('sCveSector', $_POST)) { 
            $cl1_data['sCveSector'] = $_POST['sCveSector']; 
        }if(array_key_exists('sCveManzana', $_POST)) { 
            $cl1_data['sCveManzana'] = $_POST['sCveManzana']; 
        }if(array_key_exists('bLote', $_POST)) { 
            $cl1_data['bLote'] = $_POST['bLote']; 
        }if(array_key_exists('sCasa', $_POST)) { 
            $cl1_data['sCasa'] = $_POST['sCasa']; 
        }if(array_key_exists('nRevisados', $_POST)) { 
            $cl1_data['nRevisados'] = $_POST['nRevisados']; 
        }if(array_key_exists('nAbatizados', $_POST)) { 
            $cl1_data['nAbatizados'] = $_POST['nAbatizados']; 
        }if(array_key_exists('nEliminados', $_POST)) { 
            $cl1_data['nEliminados'] = $_POST['nEliminados']; 
        }if(array_key_exists('nControlados', $_POST)) { 
            $cl1_data['nControlados'] = $_POST['nControlados']; 
        }if(array_key_exists('nNoTratados', $_POST)) { 
            $cl1_data['nNoTratados'] = $_POST['nNoTratados']; 
        }if(array_key_exists('nLarvicidaConsumido', $_POST)) { 
            $cl1_data['nLarvicidaConsumido'] = $_POST['nLarvicidaConsumido']; 
        }if(array_key_exists('nVolumenTratado', $_POST)) { 
            $cl1_data['nVolumenTratado'] = $_POST['nVolumenTratado']; 
        }if(array_key_exists('nHabitantes', $_POST)) { 
            $cl1_data['nHabitantes'] = $_POST['nHabitantes']; 
        }if(array_key_exists('sObservaciones', $_POST)) { 
            $cl1_data['sObservaciones'] = $_POST['sObservaciones']; 
        }


    } else if($_GET) {
        if(array_key_exists('sEstado', $_GET)){
            $cl1_data['sEstado'] = $_GET['sEstado'];
        }if(array_key_exists('CveBrigada', $_GET)){
            $cl1_data['CveBrigada'] = $_GET['CveBrigada'];
        }
    }
    return $cl1_data;
}


handler();
?>
