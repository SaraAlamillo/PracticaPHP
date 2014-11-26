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
    
    public function insertarUsuario($valores) {
        $this->conexion->Insertar($this->tabla, $valores);
    }

    public function modificarUsuario($codigo, $datos) {
        return $this->conexion->Actualizar($this->tabla, $codigo, $datos);
    }

    public function eliminarUsuario($id) {
        return $this->conexion->Borrar($this->tabla, $id);
    }

    public function existeUsuario($usuario, $clave) {
        return $this->conexion->existeElemento($this->tabla, ["nombre" => $usuario, "clave" => $clave]);
    }

}
