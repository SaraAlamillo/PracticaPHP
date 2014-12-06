<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelInstaller
 *
 * @author 2daw
 */
class ModelInstaller {
    private $conexion;
    
    public function __construct() {
        $this->conexion = DataBase::getInstance();
    }
    
    public static function probarConexion($parametros, &$error) {
        return DataBase::pruebaConexion($parametros, $error);
    }
    
    public function tablasExistentes($bd){
        return $this->conexion->mostrarTablas($bd);
    }
    
    public function eliminarTablas($bd) {
        return $this->conexion->eliminarTodasTablas($bd);
        
    }
    
    public function hacerConsulta($sql, &$error) {
        echo $sql . "<br />";
    return $this->conexion->consulta($sql, $error);
    }
}
