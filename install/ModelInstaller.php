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
    
    public function __construct($parametros) {
        $conexion = DataBase::getInstance($parametros);
    }
    
    public static function probarConexion($parametros, &$error) {
        return DataBase::pruebaConexion($parametros, $error);
    }
    
    public function tablasExistentes(){
        return $this->conexion->mostrarTablas();
    }
}
