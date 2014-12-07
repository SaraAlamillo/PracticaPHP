<?php

/**
 * Contiene las diferentes funciones que emulan los modelos para los controladores
 *
 * @author Sara
 */
class ModelUsuarios {

    /**
     * Enlace con la capa de abstacción de base de datos
     * @var Object 
     */
    private $conexion;

    /**
     * Nombre de la tabla sobre la que trabajará el modelo
     * @var String 
     */
    private $tabla = "usuarios";

    /**
     * Contructor de la clase ModelUsuarios
     */
    public function __construct() {
        $this->conexion = DataBase::getInstance();
    }

    /**
     * Devuelve todos los usuarios de la base de datos
     * @param Array $condiciones Criterios para obtener los usuarios
     * @param String $limite Intervalo de registros que se obtendrán
     * @return Array Conjunto de datos de los diversos usuarios
     */
    public function listarUsuarios($condiciones = NULL, $limite = NULL) {
        return $this->conexion->Seleccionar($this->tabla, "*", NULL, $limite, NULL);
    }

    /**
     * Devuelve los datos de un usuario determinado
     * @param String $codigo Identificador del usuario
     * @return Array Conjunto de datos del usuario
     */
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

    /**
     * Añade un nuevo usuario a la base de datos
     * @param Array $valores Valores para el nuevo usuario
     * @return Boolean Depende del resultado de la consulta
     */
    public function insertarUsuario($valores) {
        return $this->conexion->Insertar($this->tabla, $valores);
    }

    /**
     * Actualiza los datos de usuario determinado
     * @param String $codigo Identificador del usuario
     * @param Array $datos Nuevos valores para el usuario
     * @return Boolean Depende del resultado de la consulta
     */
    public function modificarUsuario($codigo, $datos) {
        return $this->conexion->Actualizar($this->tabla, $codigo, "codigo", $datos);
    }

    /**
     * Borra un usuario determinado
     * @param String $codigo Identificador del usuario
     * @return Boolean Depende del resultado de la consulta
     */
    public function eliminarUsuario($codigo) {
        return $this->conexion->Borrar($this->tabla, "codigo", $codigo);
    }

    /**
     * Determina si un usuario existe 
     * @param String $usuario Valor del identificador
     * @param String $campoUsuario Nombre del campo identificador
     * @param String $clave Contraseña de usuario
     * @return Boolean Depende de la existencia del usuario
     */
    public function existeUsuario($usuario, $campoUsuario, $clave = NULL) {
        if (is_null($clave)) {
            $criterios = ["$campoUsuario" => $usuario];
        } else {
            $criterios = ["$campoUsuario" => $usuario, "clave" => $clave];
        }
        return $this->conexion->existeElemento($this->tabla, $criterios);
    }

    /**
     * Determina si un usuario tiene privilegio de administtrador
     * @param String $usuario Nombre del usuario
     * @param String $clave Contraseña del usuario
     * @return Boolean
     */
    public function esAdministrador($usuario, $clave) {
        return $this->conexion->existeElemento($this->tabla, ["nombre" => $usuario, "clave" => $clave, "rol" => "Administrador"]);
    }

    /**
     * Devuelve todos los roles que pueden tener los usuarios
     * @return Array
     */
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
