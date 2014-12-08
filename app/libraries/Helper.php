<?php

/**
 * Contiene diversas funciones auxiliares
 *
 * @author Sara
 */
class Helper {

    /**
     * Ejecuta una vista
     * @param String $rutaFichero Fichero que contiene la vista
     * @param Array $variablesDeVista Conjunto de variables que utiliza la vista
     * @return String Etiquetas HTML que se le mostrarán al usuario por pantalla
     */
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

    /**
     * Modifica un conjunto de parámetros que posteriormente se le pasará a una vista para mostrar unos resultados paginados
     * @param String $accion 
     * @param String $pagina
     * @param Object $modelo
     * @param String $metodo
     * @param Array $parametrosVista
     * @param Array $condiciones
     */
    public static function paginar($accion, &$pagina, $modelo, $metodo, &$parametrosVista, $condiciones = NULL) {
        define("MaxPagina", configPlus::$elemPag);
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
            'numeroDePaginas' => $numTotalPaginas
        ];
    }

    /**
     * Devuelve las etiquetas HTML que genera una lista desplegable
     * @param String $nombre Nombre de la lista
     * @param Array $datos Opciones que habrá en la lista
     * @param String $valorPorDefecto Valor seleccionado de la lista
     * @param Array $nullValue Opción seleccionada por defecto para no seleccionar ninguna otra
     * @param Array $camposDatos Nombre de los campos del conjunto de opciones
     * @return String Etiquetas HTML de la lista desplegable
     */
    public static function creaListaDesplegable(
    $nombre, $datos, $valorPorDefecto = NULL, $nullValue = NULL, $camposDatos = ['desc' => 'nombre', 'valor' => 'codigo']) {
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

    /**
     * Importa una base de datos
     * @param String $fichero Fichero que contiene las setencias
     * @param Object $modelo Conexión con la base de datos
     * @return Boolean Según el resultado de las consultas
     */
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
            if (!is_null($error)) {
                echo $line . "<br />";
                echo $error . "<br />";
                return false;
            }
        }
        return true;
    }

    /**
     * Obtiene los parámetros de configuración almacenados en configPlus.php
     * @return Array Parámetros de la aplicación
     */
    public static function obtenerParametros() {
        $fichero = file(RUTA_APP . "configPlus.php");
        $parametros = [];

        foreach ($fichero as $linea) {
            if (preg_match("/tiempoSesion/", $linea)) {
                $valor = substr($linea, 31);
                $parametros['tiempoSesion'] = trim($valor);
            } elseif (preg_match("/valPorDefProvincia/", $linea)) {
                $valor = substr($linea, 37);
                $parametros['defecto']['provincia'] = trim($valor);
            } elseif (preg_match("/valPorDefPoblacion/", $linea)) {
                $valor = substr($linea, 37);
                $parametros['defecto']['poblacion'] = trim($valor);
            } elseif (preg_match("/elemPag/", $linea)) {
                $valor = substr($linea, 26);
                $parametros['elemPag'] = trim($valor);
            }
        }

        return $parametros;
    }

}
