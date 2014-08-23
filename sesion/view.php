<?php

function retornar_vista($form='login') {
    $file = '../sesion/sesion_'.$form.'.php';
    $template = file_get_contents($file);
    print $template;
}

?>