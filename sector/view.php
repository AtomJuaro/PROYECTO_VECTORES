<?php
$diccionario = array(
    'subtitle'=>array(VIEW_SET_SECTOR=>'Crear un nuevo Sector',
                      VIEW_GET_SECTOR=>'Buscar sector',
                      VIEW_DELETE_SECTOR=>'Eliminar un sector',
                      VIEW_EDIT_SECTOR=>'Modificar un sector',
                      VIEW_ALL_SECTORES=>'Ver todos los sectores',
                      VIEW_TABLE_SECTORES=>'Resultados'
                     ),
    'links_menu'=>array(
        'VIEW_SET_SECTOR'=>MODULO.VIEW_SET_SECTOR.'/',
        'VIEW_GET_SECTOR'=>MODULO.VIEW_GET_SECTOR.'/',
        'VIEW_EDIT_SECTOR'=>MODULO.VIEW_EDIT_SECTOR.'/',
        'VIEW_DELETE_SECTOR'=>MODULO.VIEW_DELETE_SECTOR.'/',
        'VIEW_ALL_SECTORES'=>MODULO.VIEW_ALL_SECTORES.'/',
        'VIEW_TABLE_SECTORES'=>MODULO.VIEW_TABLE_SECTORES.'/'
    ),
    'form_actions'=>array(
        'SET'=>'/mvc/'.MODULO.SET_SECTOR.'/',
        'GET'=>'/mvc/'.MODULO.GET_SECTOR.'/',
        'DELETE'=>'/mvc/'.MODULO.DELETE_SECTOR.'/',
        'EDIT'=>'/mvc/'.MODULO.EDIT_SECTOR.'/',
        'ALL_SECTORES'=>'/mvc/'.MODULO.ALL_SECTORES.'/',
        'TABLE_SECTORES'=>'/mvc/'.MODULO.TABLE_SECTORES.'/'
    )
);

function get_template($form='get') {
    $file = '../site_media/html/sector_'.$form.'.html';
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
function render_dinamic_data_allSectores($html, $data){
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
function retornar_vista_allSectores($vista, $data=array()){
    global $diccionario;
    $mensaje='Resultados de la consulta';
    $formulario=get_template($vista);
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

function retornar_vista($vista, $data=array()) {
    global $diccionario;
    $html = get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    $html = str_replace('{formulario}', get_template($vista), $html);
    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);
    $html = render_dinamic_data($html, $data);
    // render {mensaje}
    if(array_key_exists('sCveSector', $data)&&
       array_key_exists('sLocalidad', $data)&&
       $vista==VIEW_EDIT_SECTOR) {
        $mensaje = 'Editar sector '.$data['sCveSector'].' '.$data['sLocalidad'];
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

