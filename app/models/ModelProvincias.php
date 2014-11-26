<?php


/**
 * Contiene las diferentes funciones que emulan los modelos
 *
 * @author Sara
 */
class ModelProvincias {

    private $conexion;
    private $tabla = "provincias";

    public function __construct() {
        $this->conexion = DataBase::getInstance();
    }

    public function obtenerTodasProvincias() {
        return $this->conexion->Seleccionar($this->tabla, "*", NULL, NULL, "nombre asc");
    }

    public function obtenerUnaProvincia($codigo) {
        $condiciones = [
            [
                "campo" => "codigo",
                "conector" => "=",
                "valor" => $codigo
            ]
        ];

        $resultado = $this->conexion->Seleccionar($this->tabla, "nombre", $condiciones, NULL, NULL);

        return $resultado[0]['nombre'];
    }
}
