<?php

/**
 * Contiene las diferentes funciones que emulan los modelos para los controladores
 *
 * @author Sara
 */
class ModelZonas {

    /**
     * Enlace con la capa de abstacción de base de datos
     * @var Object 
     */
    private $conexion;

    /**
     * Nombre de la tabla sobre la que trabajará el modelo
     * @var String 
     */
    private $tabla = "zonas";

    /**
     * Contructor de la clase ModelZonas
     */
    public function __construct() {
        $this->conexion = DataBase::getInstance();
    }

    /**
     * Comprueba si existe una zona
     * @param String $valor Valor del identificador
     * @param String $campo Nombre del campo identificador
     * @return Boolean Según la existencia de la zona
     */
    public function existeZona($valor, $campo = 'codigo') {
        return $this->conexion->existeElemento($this->tabla, [$campo => $valor]);
    }

    /**
     * Devuelve un listado de todas las zonas
     * @param Array $condiciones Criterios para listar las zonas
     * @param String $limite Intervalo de registros que devolverá
     * @return Array Conjunto de zonas encontradas
     */
    public function listarZonas($condiciones = NULL, $limite = NULL) {
        $resultado = $this->conexion->Seleccionar($this->tabla, "*", NULL, $limite, NULL);

        foreach ($resultado as $clave => $valor) {
            if ($valor['codigo'] == '0') {
                unset($resultado[$clave]);
            }
        }
        $resultado = array_values($resultado);
        return $resultado;
    }

    /**
     * Devuelve una zona determinada
     * @param String $codigo Identificador de la zona
     * @return Array Conjunto de valores de la zona
     */
    public function listarUnaZona($codigo) {
        $condiciones = [
            [
                "campo" => "codigo",
                "conector" => "=",
                "valor" => $codigo
            ]
        ];

        $resultado = $this->conexion->Seleccionar($this->tabla, "*", $condiciones, NULL, NULL);
        return $resultado[0];
    }

    /**
     * Obtiene el código de una zona a partir de su nombre
     * @param String $zonaBuscada Nombre de la zona
     * @return String Código de la zona
     */
    public function obtenerID($zonaBuscada) {
        $zonas = $this->conexion->Seleccionar($this->tabla, "*", NULL, NULL, NULL);

        foreach ($zonas as $zona) {
            if ($zona['nombre'] == $zonaBuscada) {
                return $zona['codigo'];
            }
        }
    }

    /**
     * Obtiene el nombre de una zona a partir de su código
     * @param String $zonaBuscada Código de la zona
     * @return String Nombre de la zona
     */
    public function obtenerNombre($zonaBuscada) {
        $zonas = $this->conexion->Seleccionar($this->tabla, "*", NULL, NULL, NULL);

        foreach ($zonas as $zona) {
            if ($zona['codigo'] == $zonaBuscada) {
                return $zona['nombre'];
            }
        }
    }

    /**
     * Añade una nueva zona a la base de datos
     * @param Array $valores Datos para la nueva zona
     * @return Boolean Depende del resultado de la consulta
     */
    public function insertarZona($valores) {
        return $this->conexion->Insertar($this->tabla, $valores);
    }

    /**
     * Actualiza una zona determinada con unos valores pasados
     * @param String $codigo Identificador de la zona
     * @param Array $datos Valores nuevos para la zona
     * @return Boolean Depende del resultado de la consulta
     */
    public function modificarZona($codigo, $datos) {
        return $this->conexion->Actualizar($this->tabla, $codigo, "codigo", $datos);
    }

    /**
     * Borra una zona determinada
     * @param String $codigo Identicador de la zona
     * @return Boolean Depende del resultado de la consulta
     */
    public function eliminarZona($codigo) {
        return $this->conexion->Borrar($this->tabla, "codigo", $codigo);
    }

    /**
     * Determina si una zona contiene envíos
     * @param String $codigo Identificador de la zona
     * @return boolean Depende de si existe algún envío en esta zona
     */
    public function zonaUtilizada($codigo) {
        $resultado = $this->conexion->Seleccionar("envios", "*", NULL, NULL, NULL, "zona_envio=$codigo or zona_recepcion=$codigo");

        if (count($resultado) != 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
