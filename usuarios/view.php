<?php
$diccionario = array(
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
    $file = '../site_media/html/user_'.$form.'.php';
    $template = file_get_contents($file);
    print '<br><br>GET TEMPLATE:_  '.$file;
    return $template;
}

function render_dinamic_data($html, $data) {
    print '<br><br>dentro de render<br>';
    print_r($data);
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
    print "<br>dentro de render<br>";
    //print $html;
    foreach ($data as $clave=>$valor){
        foreach ($valor as $claveb => $valorb){
            print "<br>";
            print $valorb;
            $html=str_replace('{'.$claveb.'}', $valorb , $html);
        }
        //print $html;
    }
    return $html;
}
function retornar_vista2($vista, $data=array()){
    global $diccionario;
    $html = get_template('template');

}

function retornar_vista($vista, $data=array()) {
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);
    print "<br>DEspues de LINKS";
    //VERIFICAR SI ES LA OPCIÒN TODOS, EN CUYO CASO LLAMAS A RENDER2
    //RENDER2 PINTA CABECERA DE TABLA, POR CADA LINEA HACE UNA SUSTITUCION
    print "<br>VISTA_reetornar_vista:   ".$vista;
    //print "TIPO DE VARIABLE". gettype($html);
   if($vista=="tabla"){
        print "<br>dentro de if retornar vista";
        $html= render_dinamic_data_allUsers($html, $data);
        //print $html;
    }else{
        $html = render_dinamic_data($html, $data);
    }   
    print "<br> Despues de datos";

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

