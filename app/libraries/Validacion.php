<?php

class TratamientoFormularios {

    //devuelve un array con los posibles errores
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

    public static function validarCodigo($codigoEnvio) {
        $opciones = array("options" =>
            array("min_range" => 0, "max_range" => 99999999));
        return filter_var($codigoEnvio, FILTER_VALIDATE_INT, $opciones);
    }

    static function cp($valor) {
        //El código postal en España son cinco números. Los dos primeros van del 01 al 52 (las provincias)
        //y los tres restantes pueden ser cualquier valor numérico
        $permitidos = '/^0[1-9][0-9]{3}|[1-4][0-9]{4}|5[0-2][0-9]{3}$/';
        if (preg_match($permitidos, $valor)) {
            return true;
        } else {
            return false;
        }
    }

    static function provincias($valor) {
        //Las provincias en España van numeradas desde el 01 hasta el 52.
        $permitidos = '/[1-9]|[1-4][0-9]|5[0-2]$/';

        if (preg_match($permitidos, $valor)) {
            return true;
        } else {
            return false;
        }
    }

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

    static function fecha($input) {
        $input_array = explode("-", $input);
        if (checkdate($input_array[1], $input_array[2], $input_array[0])) {
            $fechaActual = date("y-m-d");
            $fechaEntrega = date_create(input);
            $direfencia = date_diff($fechaActual, $fechaEntrega);
            if ($direfencia->format('%R') == "-") {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
