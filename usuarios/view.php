<?php
session_start();
$diccionario = array(
    'user'=>array('{sUsuario}'=>$_SESSION["sNombre"]),
    'subtitle'=>array(VIEW_SET_USER=>'Crear un nuevo usuario',
                      VIEW_GET_USER=>'Buscar usuario',
                      VIEW_DELETE_USER=>'Eliminar un usuario',
                      VIEW_EDIT_USER=>'Modificar usuario',
                      VIEW_ALL_USERS=>'Ver todos los usuarios',
                      VIEW_TABLE_USERS=>'Resultados'
                     ),
    'links_menu'=>array(
        'VIEW_SET_USER'=>MODULO.VIEW_SET_USER.'/',
        'VIEW_GET_USER'=>MODULO.VIEW_GET_USER.'/',
        'VIEW_EDIT_USER'=>MODULO.VIEW_EDIT_USER.'/',
        'VIEW_DELETE_USER'=>MODULO.VIEW_DELETE_USER.'/',
        'VIEW_ALL_USERS'=>MODULO.VIEW_ALL_USERS.'/',
        'VIEW_TABLE_USERS'=>MODULO.VIEW_TABLE_USERS.'/'
    ),
    'form_actions'=>array(
        'SET'=>'/mvc/'.MODULO.SET_USER.'/',
        'GET'=>'/mvc/'.MODULO.GET_USER.'/',
        'DELETE'=>'/mvc/'.MODULO.DELETE_USER.'/',
        'EDIT'=>'/mvc/'.MODULO.EDIT_USER.'/',
        'ALL_USERS'=>'/mvc/'.MODULO.ALL_USERS.'/',
        'TABLE_USERS'=>'/mvc/'.MODULO.TABLE_USERS.'/'
    )
);

function get_template($form='get') {
    $file = '../site_media/html/user_'.$form.'.html';
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
function render_dinamic_data_allUsers($html, $data){
    global $formulario;
    $formulario=get_template('CabeceraTabla');
    foreach ($data as $clave=>$valor){
        $formulario.=get_template('tabla');
        foreach ($valor as $claveb => $valorb){
            $formulario=str_replace('{'.$claveb.'}', $valorb , $formulario);
        }
        
    }
    $formulario.='</tbody></table></div>';
    return $formulario;
}
function retornar_vista_allUsers($vista, $data=array()){
    global $diccionario;
    $mensaje='Resultados de la consulta';
    $formulario=get_template($vista);
    $formulario=render_dinamic_data_allUsers($formulario, $data);
    $html=get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{sUsuario}', $diccionario['user']['{sUsuario}'], $html);
    if(count($data)==0){
        $mensaje='No hay datos para este usuario';
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
    if(array_key_exists('sNombre', $data)&&
       array_key_exists('sApePaterno', $data)&&
       $vista==VIEW_EDIT_USER) {
        $mensaje = 'Editar usuario '.$data['sNombre'].' '.$data['sApePaterno'];
    } else {
        if(array_key_exists('mensaje', $data)) {
            $mensaje = $data['mensaje'];
        } else {
            $mensaje = 'Datos del usuario:';
        }
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}

