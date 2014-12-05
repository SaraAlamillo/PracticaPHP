<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bdTemp
 *
 * @author 2daw
 */
class bdTemp {

    public static function pruebaConexion($parametros, &$error) {
        $conexion = @new mysqli($parametros['servidor'], $parametros['usuario'], $parametros['clave']);

        if ($conexion) {
            if (@$conexion->select_db($parametros['bd'])) {
                echo "ok";
                return true;
            } else {
                $error = "No se puede conectar con la base de datos";
                return false;
            }
        } else {
            $error = "No se puede establecer la conexión con el servidor";
            return false;
        }
    }

    public static function tablas($parametros) {
        $conexion = new mysqli($parametros['servidor'], $parametros['usuario'], $parametros['clave']);
        $resultados = $conexion->query("show tables from " . $parametros['bd']);
        $tablas = [];
        while ($row = $resultados->fetch_row()) {
            $tablas[] = $row[0];
        }
        return $tablas;
    }

    public static function eliminarTablas($parametros) {
        $conexion = new mysqli($parametros['servidor'], $parametros['usuario'], $parametros['clave']);
        $sql = "SELECT CONCAT('drop table ',table_name,'; ') FROM information_schema.tables WHERE table_schema = '{$parametros['bd']}'";
        
        $registros = $conexion->query($sql);
        $conexion->select_db($parametros['bd']);
        while ($registro = $registros->fetch_row()){
            echo $registro[0] . "<br />";
            if (! $conexion->query($registro[0])) {
                return false;
            }
        }
        return true;
    }
    
    public static function consulta($sql, $parametros) {
        $conexion = new mysqli($parametros['servidor'], $parametros['usuario'], $parametros['clave']);
        $conexion->select_db($parametros['bd']);
        echo "<br>" . $sql .  "<br>";
        if ((! empty($sql)) || $sql != "") {
            $consulta = $conexion->query($sql) or die($conexion->error);
        
        if (! $consulta) {
            return FALSE;
        }
        }
        
        
        return TRUE;
    }

}
