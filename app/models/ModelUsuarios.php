<?php

/**
 * Contiene las diferentes funciones que emulan los modelos
 *
 * @author Sara
 */
class ModelUsuarios {

    private $conexion;
    private $tabla = "usuarios";

    public function __construct() {
        $this->conexion = DataBase::getInstance();
    }

    public function listarUsuarios($limite = NULL) {
        return $this->conexion->Seleccionar($this->tabla, "*", NULL, $limite, NULL);
    }

    public function listarUnUsuario($codigo) {
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

    public function insertarUsuario($valores) {
        $this->conexion->Insertar($this->tabla, $valores);
    }

    public function modificarUsuario($codigo, $datos) {
        return $this->conexion->Actualizar($this->tabla, $codigo, "codigo", $datos);
    }

    public function eliminarUsuario($codigo) {
        return $this->conexion->Borrar($this->tabla, "codigo", $codigo);
    }

    public function existeUsuario($usuario, $campoUsuario, $clave = NULL) {
        if (is_null($clave)) {
            $criterios = ["$campoUsuario" => $usuario];
        } else {
            $criterios = ["$campoUsuario" => $usuario, "clave" => $clave];
        }
        return $this->conexion->existeElemento($this->tabla, $criterios);
    }

    public function esAdministrador($usuario, $clave) {
        return $this->conexion->existeElemento($this->tabla, ["nombre" => $usuario, "clave" => $clave, "rol" => "Administrador"]);
    }

    public function obtenerRoles() {
        return [
            [
                "nombre" => "Administrador",
                "codigo" => "Administrador"
            ],
            [
                "nombre" => "Usuario",
                "codigo" => "Usuario"
            ]
        ];
    }

}
