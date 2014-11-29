<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerZonas
 *
 * @author Sara
 */
class ControllerZonas {
    
    private $modelZonas;

    public function __construct() {
        $this->modelZonas = new ModelZonas();
    }
    
    public function cambiarZona() {
        if (isset($_POST['nuevaZona'])){
            $_SESSION['zona'] = $_POST['nuevaZona'];
        }
        require RUTA_VIEWS . 'zonas/cambioZona.php';
    }
}
