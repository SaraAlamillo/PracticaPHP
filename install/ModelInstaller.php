<?php

/**
 * Contiene las funciones del modelo del instalador
 *
 * @author 2daw
 */
class ModelInstaller {

    /**
     * Enlace con la capa de abstracción de la base de datos
     * @var Object
     */
    private $conexion;

    /**
     * Contructor de la clase ModelInstaller
     */
    public function __construct() {
        $this->conexion = DataBase::getInstance();
    }

    /**
     * Comprueba si se puede realizar una conexión con los parámetros pasados
     * @param Array $parametros Contiene la configuración para realizar la prueba
     * @param String $error Si hay algún error, contiene dicho error
     * @return Boolean Depende de si se puede establecer la conexión
     */
    public static function probarConexion($parametros, &$error) {
        return DataBase::pruebaConexion($parametros, $error);
    }

    /**
     * Devuelve todas las tablas existentes en una base de datos determinada
     * @param String $bd Nombre de la base de datos
     * @return Array Conjunto de tablas
     */
    public function tablasExistentes($bd) {
        return $this->conexion->mostrarTablas($bd);
    }

    /**
     * Borra todas las tablas de una base de datos determinada
     * @param String $bd Nombre de la base de datos
     * @return Boolean Depende del resultado
     */
    public function eliminarTablas($bd) {
        return $this->conexion->eliminarTodasTablas($bd);
    }

    /**
     * Ejecuta una setencia
     * @param String $sql Contiene la consulta a ejecutar
     * @param String $error Si hay algún error en la ejecucción, contiene dicho error
     * @return Boolean Depende del resultado de la consulta
     */
    public function hacerConsulta($sql, &$error) {
        return $this->conexion->consulta($sql, $error);
    }

}
