<?php

class ModelZonas {

    private $conexion;
    private $tabla = "zonas";

    public function __construct() {
        $this->conexion = DataBase::getInstance();
    }

    public function existeZona($valor, $campo = 'codigo') {
        return $this->conexion->existeElemento($this->tabla, [$campo => $valor]);
    }

    public function listarZonas($condiciones = NULL, $limite = NULL) {
        return $this->conexion->Seleccionar($this->tabla, "*", NULL, $limite, NULL);
    }

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

    public function insertarZona($valores) {
        return $this->conexion->Insertar($this->tabla, $valores);
    }
    
    public function modificarZona($codigo, $datos) {
        return $this->conexion->Actualizar($this->tabla, $codigo, "codigo", $datos);
    }

    public function eliminarZona($codigo) {
        return $this->conexion->Borrar($this->tabla, "codigo", $codigo);
    }
}
