<?php

/**
 * Contiene las diferentes funciones que emulan los modelos para los controladores
 *
 * @author Sara
 */
class ModelProvincias {

    /**
     * Enlace con la capa de abstacción de base de datos
     * @var Object 
     */
    private $conexion;

    /**
     * Nombre de la tabla sobre la que trabajará el modelo
     * @var String 
     */
    private $tabla = "provincias";

    /**
     * Contructor de la clase ModelProvincias
     */
    public function __construct() {
        $this->conexion = DataBase::getInstance();
    }

    /**
     * Devuelve todos los datos de todas las provincias existentes en la base de dato
     * @return Array Conjunto de provincias
     */
    public function obtenerTodasProvincias() {
        return $this->conexion->Seleccionar($this->tabla, "*", NULL, NULL, "nombre asc");
    }

    /**
     * Devuelve el nombre de una provincia determinada
     * @param String $codigo Identificador de la provincia
     * @return Array Datos de la provincia buscada
     */
    public function obtenerUnNombre($codigo) {
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

    /**
     * Devuelve el identificador de una provincia determinada
     * @param String $nombre Nombre de la provincia
     * @return Array Datos de la provincia buscada
     */
    public function obtenerUnId($nombre) {
        $condiciones = [
            [
                "campo" => "nombre",
                "conector" => "=",
                "valor" => $nombre
            ]
        ];

        $resultado = $this->conexion->Seleccionar($this->tabla, "codigo", $condiciones, NULL, NULL);

        return $resultado[0]['codigo'];
    }

}
