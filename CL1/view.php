<?php
session_start();
$diccionario = array(
    'user'=>array('{sUsuario}'=>$_SESSION["sNombre"]),
    'subtitle'=>array(VIEW_SET_CL1=>'Registrar un nuevo CL1',
                      VIEW_GET_CL1=>'Buscar CL1',
                      VIEW_DELETE_CL1=>'Eliminar CL1 Existente',
                      VIEW_EDIT_CL1=>'Modificar CL1',
                      VIEW_ALL_CL1=>'Ver todos los CL1',
                      VIEW_TABLE_CL1=>'Resultados',
                      VIEW_GET_BRIGADA=>'Busqueda de brigadas',
                      VIEW_TABLE_BRIGADAS=>'Brigadas activas',
                      VIEW_GET_CL1_DATA=>'Busqueda de datos en CL1',
                      VIEW_GET_DATA=>'Editar datos',
                      VIEW_SET_DATA=>'Agregar datos al CL1'
                     ),
    'links_menu'=>array(
        'VIEW_SET_CL1'=>MODULO.VIEW_SET_CL1.'/',
        'VIEW_GET_CL1'=>MODULO.VIEW_GET_CL1.'/',
        'VIEW_EDIT_CL1'=>MODULO.VIEW_EDIT_CL1.'/',
        'VIEW_DELETE_CL1'=>MODULO.VIEW_DELETE_CL1.'/',
        'VIEW_ALL_CL1'=>MODULO.VIEW_ALL_CL1.'/',
        'VIEW_TABLE_CL1'=>MODULO.VIEW_TABLE_CL1.'/',
        'VIEW_GET_BRIGADA'=>MODULO.VIEW_GET_BRIGADA.'/',
        'VIEW_TABLE_BRIGADAS'=>MODULO.VIEW_TABLE_BRIGADAS.'/',
        'VIEW_GET_CL1_DATA'=>MODULO.VIEW_GET_CL1_DATA.'/',
        'VIEW_GET_DATA'=>MODULO.VIEW_GET_DATA.'/',
        'VIEW_SET_DATA'=>MODULO.VIEW_SET_DATA.'/'
    ),
    'form_actions'=>array(
        'SET_CL1'=>'/mvc/'.MODULO.SET_CL1.'/',
        'GET_CL1'=>'/mvc/'.MODULO.GET_CL1.'/',
        'DELETE_CL1'=>'/mvc/'.MODULO.DELETE_CL1.'/',
        'EDIT_CL1'=>'/mvc/'.MODULO.EDIT_CL1.'/',
        'EDIT_OBS'=>'/mvc/'.MODULO.EDIT_OBS.'/',
        'TABLE_CL1'=>'/mvc/'.MODULO.TABLE_CL1.'/',
        'GET_BRIGADA'=>'/mvc/'.MODULO.GET_BRIGADA.'/',
        'GET_CL1_DATA' =>'/mvc/'.MODULO.GET_CL1_DATA.'/',
        'SET_CL1_DATA' => '/mvc/'.MODULO.SET_CL1_DATA.'/',
        'GET_CL1_CABECERA'=>'/mvc/'.MODULO.GET_CL1_CABECERA.'/',
        'SET_DATA'=>'/mvc/'.MODULO.SET_DATA.'/',
        'GET_DATA'=>'/mvc/'.MODULO.GET_DATA.'/',
        'SET_FILA'=>'/mvc/'.MODULO.SET_FILA.'/',
        'DELETE'=>'/mvc/'.MODULO.DELETE.'/'
    )
);

function get_template($form='get') {
    $file = '../site_media/html/CL1_'.$form.'.html';
    $template = file_get_contents($file);
    return $template;
}

function render_dinamic_data($html, $data) {
    foreach ($data as $clave=>$valor) {
        if (is_array($valor)){
            foreach ($valor as $claveb => $valorb) {
            $html = str_replace('{'.$claveb.'}', $valorb , $html);
            }
        }else{
        $html = str_replace('{'.$clave.'}', $valor, $html);
        }
    }

    return $html;
}
function render_dinamic_data_allBrigadas($html, $data){
    global $formulario;
    if($html=='tabla'){
        $tabla='cl1Activos';
        $cabecera='cabeceraCL1';
    }else{
        $tabla='Brigadas';
        $cabecera='cabeceraBrigadas';
    }
    $formulario=get_template($cabecera);
    foreach ($data as $clave=>$valor){
        $formulario.=get_template($tabla);
        foreach ($valor as $claveb => $valorb){
            $formulario=str_replace('{'.$claveb.'}', $valorb , $formulario);
        }
        
    }
    $formulario.='</tbody></table></div>';
    return $formulario;
}
function retornar_vista_allBrigadas($vista, $data=array()){
    global $diccionario;
    $mensaje='Resultados de la consulta';
    $formulario=$vista;
    $formulario=render_dinamic_data_allBrigadas($formulario, $data);
    $html=get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{sUsuario}', $diccionario['user']['{sUsuario}'], $html);
    if(count($data)==0){
        $mensaje='No hay resultados para estos datos';
        $html = str_replace('{formulario}', 'ERROR', $html);
    }else{
    $html = str_replace('{formulario}', $formulario, $html);
    }
    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);
    $html = str_replace('{mensaje}', $mensaje, $html);
    print $html;

    

}

function retornar_vista($vista, $data=array()) {
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = str_replace('{sUsuario}', $diccionario['user']['{sUsuario}'], $html);
    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);
    $html = render_dinamic_data($html, $data);
    // render {mensaje}
    if(array_key_exists('sCveBrigada', $data)&&
       array_key_exists('sLocalidad', $data)&&
       $vista==VIEW_EDIT_BRIGADA) {
        $mensaje = 'Editar brigada '.$data['sCveBrigada'].' en '.$data['sLocalidad'];
    } else {
        if(array_key_exists('mensaje', $data)) {
            $mensaje = $data['mensaje'];
        } else {
            $mensaje = 'Datos del CL1:';
        }
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}

function render_dinamic_data_tablaCL1($html, $data){
    global $formulario;
    foreach ($data as $clave=>$valor){
        $formulario.=get_template('tabla');
        foreach ($valor as $claveb => $valorb){
            $formulario=str_replace('{'.$claveb.'}', $valorb , $formulario);
        }
        
    }
    return $formulario;
}
function retornar_vista_tablaCL1($vista, $data=array()){
    global $diccionario;
    $datoscl1=array();
    $cl1=array();
    $observaciones=array();
    $datos=array();
    $datoscl1=array_slice($data,0,13 );
    $cl1=array_slice($data,14);
    $observaciones=array_slice($data,13, 1);
    $datos=array_slice($data, -1,1);
    $observaciones=array_merge($observaciones, $datos);
    $mensaje='Resultados de la consulta';
    $formulario=$vista;
    $formulario=render_dinamic_data(get_template('CabeceraModificar'), $datoscl1);
    $formulario.=render_dinamic_data_tablaCL1($formulario, $cl1);
    $formulario.=render_dinamic_data(get_template('editarObs'), $observaciones);
    $formulario.='';
    $html=get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{sUsuario}', $diccionario['user']['{sUsuario}'], $html);
    if(count($data)==0){
        $mensaje='No hay resultados para estos datos';
        $html = str_replace('{formulario}', 'ERROR', $html);
    }else{
    $html = str_replace('{formulario}', $formulario, $html);
    }
    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);
    $html = str_replace('{mensaje}', $mensaje, $html);
    print $html;
}
