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

}

