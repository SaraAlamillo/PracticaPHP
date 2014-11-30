<?php

class ModelZonas {

    private $conexion;
    private $tabla = "zonas";

    public function __construct() {
        $this->conexion = DataBase::getInstance();
    }

    public function obtenerZonas() {
        return $this->conexion->Seleccionar($this->tabla, "*", NULL, NULL, NULL);
    }

    public function existeZona($codigo) {
        return $this->conexion->existeElemento($this->tabla, ['codigo' => $codigo]);
    }

    public function listarZonas() {
        return $this->conexion->Seleccionar($this->tabla, "*", NULL, NULL, NULL);
    }

    public function obtenerID($zonaBuscada) {
        $zonas = $this->conexion->Seleccionar($this->tabla, "*", NULL, NULL, NULL);

        foreach ($zonas as $zona) {
            if ($zona['nombre'] == $zonaBuscada) {
                return $zona['codigo'];
            }
        }
    }

    public function obtenerNombre($zonaBuscada) {
        $zonas = $this->conexion->Seleccionar($this->tabla, "*", NULL, NULL, NULL);

        foreach ($zonas as $zona) {
            if ($zona['codigo'] == $zonaBuscada) {
                return $zona['nombre'];
            }
        }
    }

}
