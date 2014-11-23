<?php

function creaListaDesplegable(
        $nombre, 
        $datos, 
        $valorPorDefecto = NULL, 
        $nullValue = NULL, 
        $camposDatos = ['desc' => 'nombre', 'valor' => 'codigo']) {
    $html = "<select name='$nombre'>\n";

    if (is_array($nullValue)) {
        if ($nullValue[$camposDatos['valor']] == $valorPorDefecto) {
            $html .= "<option value='{$nullValue[$camposDatos['valor']]}' selected='selected'>{$nullValue[$camposDatos['desc']]}</option>\n";
        } else {
            $html .= "<option value='{$nullValue[$camposDatos['valor']]}'>{$nullValue[$camposDatos['desc']]}</option>\n";
        }
    }

    foreach ($datos as $dato) {
        // TODO: comprobar la lista de estados del buscador
        if ($dato[$camposDatos['valor']] == $valorPorDefecto) {
            $html .= "<option value='{$dato[$camposDatos['valor']]}' selected='selected'>{$dato[$camposDatos['desc']]}</option>\n";
        } else {
            $html .= "<option value='{$dato[$camposDatos['valor']]}'>{$dato[$camposDatos['desc']]}</option>\n";
        }
    }

    $html .= "</select>\n";
    
    return $html;
}
