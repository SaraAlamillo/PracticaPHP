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
    
    public function tablasExistentes(){
        return $this->conexion->mostrarTablas();
    }
    
    public function eliminarTablas() {
        return $this->conexion->eliminarTodasTablas();
        
    }
    
    public function hacerConsulta($sql, &$error) {
    return $this->conexion->consulta($sql, $error);
    }
}
