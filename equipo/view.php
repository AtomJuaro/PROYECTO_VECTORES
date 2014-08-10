<?php
$diccionario = array(
    'subtitle'=>array(VIEW_SET_EQUIPO=>'Crear un nuevo equipo',
                      VIEW_GET_EQUIPO=>'Buscar equipo',
                      VIEW_GET_BRIGADA=>'Busqueda de brigada',
                      VIEW_DELETE_EQUIPO=>'Eliminar un equipo',
                      VIEW_EDIT_EQUIPO=>'Modificar equipo',
                      VIEW_TABLE_BRIGADAS=>'Brigadas encontradas',
                      VIEW_TABLE_JEFE=>'Seleccion de jefe de brigada',
                      VIEW_TABLE_APLICATIVO=>'Selecciona los aplicativos',
                      VIEW_TABLE_EQUIPO=>'Miembros del equipo:',
                      VIEW_TABLE_EDITJEFE=>'Cambio de Jefe de Brigada',
                      VIEW_TABLE_EDITAPLICATIVO=>'Cambio de Aplicativo',
                      VIEW_TABLE_ALLEQUIPO=>'Equipos activos',
                      VIEW_ALL_EQUIPO=>'Selecciona el estado de la brigada'

                     ),
    'links_menu'=>array(
        'VIEW_SET_EQUIPO'=>EQUIPO.VIEW_SET_EQUIPO.'/',
        'VIEW_GET_EQUIPO'=>EQUIPO.VIEW_GET_EQUIPO.'/',
        'VIEW_GET_BRIGADA'=>EQUIPO.VIEW_GET_BRIGADA.'/',
        'VIEW_EDIT_EQUIPO'=>EQUIPO.VIEW_EDIT_EQUIPO.'/',
        'VIEW_DELETE_EQUIPO'=>EQUIPO.VIEW_DELETE_EQUIPO.'/',
        'VIEW_TABLE_BRIGADAS'=>EQUIPO.VIEW_TABLE_BRIGADAS.'/',
        'VIEW_TABLE_JEFE'=>EQUIPO.VIEW_TABLE_JEFE.'/',
        'VIEW_TABLE_EQUIPO'=>EQUIPO.VIEW_TABLE_EQUIPO.'/',
        'VIEW_TABLE_EDITJEFE'=>EQUIPO.VIEW_TABLE_EDITJEFE.'/',
        'VIEW_TABLE_EDITAPLICATIVO'=>EQUIPO.VIEW_TABLE_EDITAPLICATIVO.'/',
        'VIEW_TABLE_ALLEQUIPO'=>EQUIPO.VIEW_TABLE_ALLEQUIPO.'/',
        'VIEW_ALL_EQUIPO'=>EQUIPO.VIEW_ALL_EQUIPO.'/'

    ),
    'form_actions'=>array(
        'SET'=>'/mvc/'.EQUIPO.SET_EQUIPO.'/',
        'GET'=>'/mvc/'.EQUIPO.GET_EQUIPO.'/',
        'GET_BRIGADA'=>'/mvc/'.EQUIPO.GET_BRIGADA.'/',
        'DELETE'=>'/mvc/'.EQUIPO.DELETE_EQUIPO.'/',
        'DELETE_USER'=>'/mvc/'.EQUIPO.DELETE_USER.'/',
        'EDIT'=>'/mvc/'.EQUIPO.EDIT_EQUIPO.'/',
        'GET_JEFE'=>'/mvc/'.EQUIPO.GET_JEFE.'/',
        'SET_JEFE'=>'/mvc/'.EQUIPO.SET_JEFE.'/',
        'GET_APLICATIVO'=>'/mvc/'.EQUIPO.GET_APLICATIVO.'/',
        'SET_APLICATIVO'=>'/mvc/'.EQUIPO.SET_APLICATIVO.'/',
        'EDIT_JEFE'=>'/mvc/'.EQUIPO.EDIT_JEFE.'/',
        'EDIT_APLICATIVO'=>'/mvc/'.EQUIPO.EDIT_APLICATIVO.'/',
        'ALL_EQUIPO'=>'/mvc/'.EQUIPO.ALL_EQUIPO.'/'
    )
);

function get_template($form='get') {
    $file = '../site_media/html/EquipoBrigada_'.$form.'.html';
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
    $cabecera='';
    $tabla='';
    switch ($html){
        case "tablaAplicativo":
            $cabecera='cabeceraAplicativo';
            $tabla='aplicativo';
            break;
        case "tablaJefes":
            $cabecera='cabeceraJefeBrigada';
            $tabla='jefeBrigada';
            break;
        case "editJefe":
            $cabecera='editJefeCabecera';
            $tabla='editJefe';
            break;
        case "editAplicativo":
            $cabecera='editAplicativoCabecera';
            $tabla='editAplicativo';
            break;
        case "tablaEquipos":
            $cabecera='tablaEquiposCabecera';
            $tabla='tablaEquipos';
            break;
        default:
            $cabecera='cabeceraEquipo';
            $tabla='equipo';
   }
    $n=count($data);
    $formulario=get_template($cabecera);
    foreach ($data as $clave=>$valor){
        if(count($valor)>1 || $html=='tablaEquipos'){
        $formulario.=get_template($tabla);
        } if( $clave==$n-1 && $html=='tablaEquipo'){
            while($n<7){
            $formulario.='<tr><td colspan="7" align="right">
                        <form id="agregar_usuario" action="{EDIT}" method="POST">
                        <input type="hidden" name="CveBrigada" id="CveBrigada" value="{CveBrigada}"/>
                        <input type="hidden" name="sTipoUsuario" id="sTipoUsuario" value="Aplicativo"/>
                        <input type="submit" id="enviar" value="Agregar otro aplicativo"/>
                        </td></tr>';
            $n++;
            }
        }
        foreach ($valor as $claveb => $valorb){
            $formulario=str_replace('{'.$claveb.'}', $valorb , $formulario);
        }
        
    }
    if($html=='tablaAplicativo'){
        $formulario.='</tbody></table><input type="submit" id="enviar" value="Seleccionar" onclick="bPreguntar = false;" onsubmit="return verificar();"/></form></div>';
    }else{
        $formulario.='</tbody></table></div>';
    }
    return $formulario;
}
function retornar_vista_allUsers($vista, $data=array()){
    global $diccionario;
    $mensaje='Resultados de la consulta';
    $formulario=$vista;
    $formulario=render_dinamic_data_allUsers($formulario, $data);
    $html=get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    
    if(count($data)==0 && $vista=='tablaAplicativo'){
        print "dentro de ir";
        $mensaje='No hay datos que mostrar';
        $html = str_replace('{formulario}', '<h2>ERROR</h2><BR> Si no ve datos en esta vista puede ser que:<br>
            <li> La base de datos no cuenta con los datos requeridos </li>
            <li> Si cree que esto es un error contacte al administrador', $html);
    }else if(count($data)<=1 ){
        $mensaje='No hay datos que mostrar';
        $html = str_replace('{formulario}', '<h2>ERROR</h2><BR> Si no ve datos en esta vista puede ser que:<br>
            <li> La base de datos no cuenta con los datos requeridos </li>
            <li> Si cree que esto es un error contacte al administrador', $html);
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
    if(array_key_exists('CveBrigada', $data)&& $vista==VIEW_EDIT_EQUIPO) {
        $mensaje = 'Editar equipo de brigada '.$data['CveBrigada'];
    } else {
        if(array_key_exists('mensaje', $data)) {
            $mensaje = $data['mensaje'];
        } else {
            $mensaje = 'Usuarios en brigada:';
        }
    }
    $html = str_replace('{mensaje}', $mensaje, $html);

    print $html;
}

function render_dinamic_data_allBrigadas($html, $data=array()){
    global $formulario;
    $formulario=get_template('cabeceraTablaBrigadas');
    foreach ($data as $clave=>$valor){
        $formulario.=get_template('tablaBrigada');
        foreach ($valor as $claveb => $valorb){
            $formulario=str_replace('{'.$claveb.'}', $valorb , $formulario);
        }
        
    }
    $formulario.='</tbody></table></div>';
    return $formulario;
}
function retornar_vista_allBrigadas($vista, $data=array()){
    global $diccionario;
    $mensaje='Seleccione la brigada a la que se agregara el equipo';
    $formulario=get_template($vista);
    $formulario=render_dinamic_data_allBrigadas($formulario, $data);
    $html=get_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitle'][$vista], $html);
    if(count($data)==0){
        $mensaje='No hay brigadas que mostrar';
        $html = str_replace('{formulario}', '<h2>ERROR</h2><BR> Si no ve datos en esta vista<br>
            <li> No hay datos disponibles para mostrar</li>
            <li> Si cree que esto es un error contacte al administrador ', $html);
    }else{
    $html = str_replace('{formulario}', $formulario, $html);
    }
    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);
    $html = str_replace('{mensaje}', $mensaje, $html);
    print $html;

    

}

