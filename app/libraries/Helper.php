<?php

/**
 * Description of Helper
 *
 * @author Sara
 */
class Helper {

    public static function & CargaVista($rutaFichero, array $variablesDeVista = NULL) {
        if (!file_exists($rutaFichero)) {
            return "No existe: $rutaFichero"; // Nada que incluir
        }
        if (!is_null($variablesDeVista)) {
            // Creamos variables que hemos pasado en el array
            foreach ($variablesDeVista as $nombreVariableArrayEnForeach => $valorVariableArray) {   // OJO al doble $
                $$nombreVariableArrayEnForeach = $valorVariableArray;
            }
        }
        // Interpretamos plantilla
        ob_start();
        include($rutaFichero);
        $contenido = ob_get_clean();

        return $contenido;
    }

    public static function paginar($accion, &$pagina, $modelo, $metodo, &$parametrosVista, $condiciones = NULL) {
    define("MaxPagina", "2");
    $numTotalPaginas = ceil(count($modelo->$metodo($condiciones)) / MaxPagina);

    if (empty($pagina)) {
        $inicio = 0;
        $pagina = 1;
    } else if ($pagina < 1) {
        $pagina = 1;
        $inicio = ($pagina - 1) * MaxPagina;
    } elseif ($pagina > $numTotalPaginas) {
        $pagina = $numTotalPaginas;
        $inicio = ($pagina - 1) * MaxPagina;
    } else {
        $inicio = ($pagina - 1) * MaxPagina;
    }
  
    $parametrosVista = [
        'datos' => $modelo->$metodo($condiciones, $inicio . "," . MaxPagina),
        'action' => $accion,
        'paginaActual' => $pagina,
        'numeroDePaginas' => $numTotalPaginas,
        'controlesActivos' => [
            'primero' => '',
            'anterior' => '',
            'siguiente' => '',
            'ultimo' => ''
        ]
    ];

    if ($pagina == 1) {
        $parametrosVista['controlesActivos']['primero'] = "  noMostrar";
        $parametrosVista['controlesActivos']['anterior'] = " noMostrar";
    }
    if ($pagina == $parametrosVista['numeroDePaginas']) {
        $parametrosVista['controlesActivos']['siguiente'] = " noMostrar";
        $parametrosVista['controlesActivos']['ultimo'] = " noMostrar";
    }
}
public static function creaListaDesplegable(
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
        if ($dato[$camposDatos['valor']] == $valorPorDefecto) {
            $html .= "<option value='{$dato[$camposDatos['valor']]}' selected='selected'>{$dato[$camposDatos['desc']]}</option>\n";
        } else {
            $html .= "<option value='{$dato[$camposDatos['valor']]}'>{$dato[$camposDatos['desc']]}</option>\n";
        }
    }

    $html .= "</select>\n";
    
    return $html;
}

public static function importSql($fichero, $modelo) {
    $lines = file($fichero);
    foreach ($lines as $key => $line) {
        if (substr($line, 0, 2) == "--") {
            unset($lines[$key]);
        }
    }
    $lines = array_values($lines);

    $lines = implode(" ", $lines);
    $lines = explode(";", $lines);
    
    foreach ($lines as $line) {
        $modelo->hacerConsulta($line, $error);
        if (! is_null($error)) {
            echo $line . "<br />";
            echo $error . "<br />";
            return false;
        }
    }
    return true;
}

}
