<?php

/**
 * Encargada de la validación de los datos de los envíos
 */
class TratamientoFormularios {

    /**
     * Filtra los datos y devuelve los posibles errores
     * @param Array $criterios Criterios a seguir en la validación
     * @return Array Conjunto de datos no válidos
     */
    static public function validarArray($criterios) {
        $datosValidados = filter_input_array(INPUT_POST, $criterios);
        $datosErroneos = array();
        foreach ($datosValidados as $clave => $valor) {
            if (!$valor) {
                $datosErroneos[$clave] = true;
            }
        }
        return $datosErroneos;
    }

    /**
     * Valida el código postal
     * @param String $valor Código postal
     * @return boolean Según si es válido o no
     */
    static function cp($valor) {
        //El código postal en España son cinco números. Los dos primeros van del 01 al 52 (las provincias) y los tres restantes pueden ser cualquier valor numérico
        $permitidos = '/^0[1-9][0-9]{3}|[1-4][0-9]{4}|5[0-2][0-9]{3}$/';
        if (preg_match($permitidos, $valor)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Válida el código de una provincia
     * @param String $valor Código de provincia
     * @return boolean Según la validez del código
     */
    static function provincias($valor) {
        //Las provincias en España van numeradas desde el 01 hasta el 52.
        $permitidos = '/[1-9]|[1-4][0-9]|5[0-2]$/';

        if (preg_match($permitidos, $valor)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Comprueba si una cadena está compuesta totalmente por letras
     * @param String $valor Cadena a comprobar
     * @return boolean Según si es alfabético o no
     */
    static function alfabetico($valor) {
        $permitidos = '/^[A-Z üÜáéíóúÁÉÍÓÚñÑ]{1,50}$/i';
        if (empty($valor)) {
            return false; // Campo vacio
        } else {
            if (preg_match($permitidos, $valor)) {
                return true; // Campo permitido 
            } else {
                return false; // Error uno de los caracteres no hace parte de la expresión regular 
            }
        }
    }

    /**
     * Comprueba que una cadena esté compuesta por letras, número y determinados símbolos
     * @param String $valor Cadena a comprobar
     * @return boolean Según la validez de la cadena
     */
    static function alfanumericoSimbolos($valor) {
        $permitidos = '/^[A-Z 0-9 üÜáéíóúÁÉÍÓÚñÑ,.-ºª"]{1,150}$/i';
        if (empty($valor)) {
            return true; // Campo vacio
        } else {
            if (preg_match($permitidos, $valor)) {
                return true; // Campo permitido 
            } else {
                return false; // Error uno de los caracteres no hace parte de la expresión regular 
            }
        }
    }

    /**
     * Comprueba que una cadena esté compuesta exclusivamente por números
     * @param String $valor Cadena a comprobar
     * @return boolean Según la validez de la cadena
     */
    static function numerico($valor) {
        if (empty($valor)) {
            return false; //campo vacio no validar
        } else {
            if (ctype_digit($valor)) {
                return true; // Si es un número
            } else {
                return false; // Error no es un número
            }
        }
    }

    /**
     * Comprueba que una fecha sea correcta
     * @param String $input Fecha a comprobar
     * @return boolean Según la validez de la fecha
     */
    static function fecha($input) {
        $input_array = explode("-", $input);
        if (checkdate($input_array[1], $input_array[2], $input_array[0])) {
            return true;
        } else {
            return false;
        }
    }

}
