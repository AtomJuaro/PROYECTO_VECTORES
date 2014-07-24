<?php
$diccionario = array(
    'subtitle'=>array(VIEW_SET_BRIGADA=>'Registrar una nueva brigada',
                      VIEW_GET_BRIGADA=>'Buscar brigada',
                      VIEW_GET_SECTOR=>'Buscar sector',
                      VIEW_DELETE_BRIGADA=>'Eliminar una brigada',
                      VIEW_EDIT_BRIGADA=>'Modificar una brigada',
                      VIEW_ALL_BRIGADAS=>'Ver todas las brigadas',
                      VIEW_TABLE_BRIGADAS=>'Resultados',
                      VIEW_TABLE_SECTORES=>'Sectores'
                     ),
    'links_menu'=>array(
        'VIEW_SET_BRIGADA'=>MODULO.VIEW_SET_BRIGADA.'/',
        'VIEW_GET_BRIGADA'=>MODULO.VIEW_GET_BRIGADA.'/',
        'VIEW_GET_SECTOR'=>MODULO.VIEW_GET_SECTOR.'/',
        'VIEW_EDIT_BRIGADA'=>MODULO.VIEW_EDIT_BRIGADA.'/',
        'VIEW_DELETE_BRIGADA'=>MODULO.VIEW_DELETE_BRIGADA.'/',
        'VIEW_ALL_BRIGADAS'=>MODULO.VIEW_ALL_BRIGADAS.'/',
        'VIEW_TABLE_BRIGADAS'=>MODULO.VIEW_TABLE_BRIGADAS.'/',
        'VIEW_TABLE_SECTORES'=>SECTOR.VIEW_TABLE_SECTORES.'/'
    ),
    'form_actions'=>array(
        'SET'=>'/mvc/'.MODULO.SET_BRIGADA.'/',
        'GET'=>'/mvc/'.MODULO.GET_BRIGADA.'/',
        'DELETE'=>'/mvc/'.MODULO.DELETE_BRIGADA.'/',
        'EDIT'=>'/mvc/'.MODULO.EDIT_BRIGADA.'/',
        'ALL_SECTORES'=>'/mvc/'.MODULO.ALL_BRIGADAS.'/',
        'TABLE_SECTORES'=>'/mvc/'.MODULO.TABLE_BRIGADAS.'/',
        'GET_SECTOR'=>'/mvc/'.MODULO.GET_SECTOR.'/'
    )
);

function get_template($form='get') {
    $file = '../site_media/html/brigada_'.$form.'.html';
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
function retornar_vista_allBrigadas($vista, $data=array()){
    global $diccionario;
    $mensaje='Resultados de la consulta';
    $formulario=get_template($vista);
    $formulario=render_dinamic_data_allBrigadas($formulario, $data);
    $html=get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
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
            $mensaje = 'Datos del sector:';
        }
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}
function render_dinamic_data_allSectores($html, $data){
    global $formulario;
    $formulario=file_get_contents('../site_media/html/sector_CabeceraTabla.html');
    foreach ($data as $clave=>$valor){
        $formulario.=get_template('tabla_sectores');
        foreach ($valor as $claveb => $valorb){
            $formulario=str_replace('{'.$claveb.'}', $valorb , $formulario);
        }
        
    }
    $formulario.='</tbody></table></div>';
    return $formulario;
}

function retornar_vista_allSectores($vista, $data=array()){
    global $diccionario;
    $mensaje='Resultados de la consulta';
    $formulario=file_get_contents('../site_media/html/brigada_tabla_sectores.html');
    $formulario=render_dinamic_data_allSectores($formulario, $data);
    $html=get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
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
