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
        if (isset($_POST['nuevaZona'])) {
            $_SESSION['zona'] = $_POST['nuevaZona'];
        }
        require RUTA_VIEWS . 'zonas/cambioZona.php';
    }

    public function listarZonas() {
        paginar(
                $_GET['action'], $_GET['pagina'], $this->modelZonas, "listarZonas", $params
        );

        if ($params['datos'] == NULL) {
            require RUTA_VIEWS . 'zonas/noDatos.php';
        } else {
            require RUTA_VIEWS . 'zonas/listar.php';
        }
    }

    public function insertarZona() {
        $params = [
            "action" => $_GET['action'],
            "datos" => [
                'nombre' => ''
            ]
        ];

        if ($_POST) {
            if ($this->modelZonas->existeZona($_POST['nombre'], "nombre")) {
                $params['datos'] = $_POST;
                $params['mensaje'] = "La zona {$_POST['nombre']} ya existe en la base de datos";
            } else {
                if ($this->modelZonas->insertarZona($_POST)) {
                    $params['mensaje'] = "Zona añadida correctamente";
                } else {
                    $params['datos'] = $_POST;
                    $params['mensaje'] = "Ups...Algo ha fallado";
                }
            }
        }

        require RUTA_VIEWS . 'zonas/formInsertar.php';
    }

    public function eliminarZona() {
        $params = [
            "action" => $_GET['action'],
            "zonas" => $this->modelZonas->listarZonas()
        ];

        if (empty($_GET['codigo'])) {
            require RUTA_VIEWS . 'zonas/formNomUsuarios.php';
        } else {
            $params['codigo'] = $_GET['codigo'];
            if ($this->modelZonas->existeZona($_GET['codigo'])) {
                if ($this->modelZonas->zonaUtilizada($_GET['codigo'])) {
                    $params['error'] = "La zona introducida está siendo utilizada";
                    require RUTA_VIEWS . 'zonas/formNomUsuarios.php';
                } else {
                    if (isset($_GET['confirmacion'])) {
                        if ($_GET['confirmacion'] == "Si") {
                            if ($this->modelZonas->eliminarZona($_GET['codigo'])) {
                                require RUTA_VIEWS . 'zonas/finalBien.php';
                            } else {
                                require RUTA_VIEWS . 'zonas/finalMal.php';
                            }
                        } else {
                            require RUTA_VIEWS . 'zonas/formNomUsuarios.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'zonas/confirmacion.php';
                    }
                }
            } else {
                $params['error'] = "El nombre de zona introducido no existe";
                require RUTA_VIEWS . 'zonas/formNomUsuarios.php';
            }
        }
    }

    public function modificarZona() {
        $params = [
            "action" => $_GET['action'],
            "zonas" => $this->modelZonas->listarZonas()
        ];

        if (empty($_GET['codigo'])) {
            require RUTA_VIEWS . 'zonas/formNomUsuarios.php';
        } else {
            $params['codigo'] = $_GET['codigo'];
            if ($this->modelZonas->existeZona($_GET['codigo'])) {
                if (isset($_GET['confirmacion'])) {
                    $params['confirmacion'] = $_GET['confirmacion'];
                    if ($_GET['confirmacion'] == "Si") {
                        $params['antiguo'] = $this->modelZonas->listarUnaZona($_GET['codigo']);
                        if ($_POST) {
                            if ($this->modelZonas->modificarZona($_GET['codigo'], $_POST)) {
                                require RUTA_VIEWS . 'zonas/finalBien.php';
                            } else {
                                require RUTA_VIEWS . 'zonas/finalMal.php';
                            }
                        } else {
                            require RUTA_VIEWS . 'zonas/formModificar.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'zonas/formNomUsuarios.php';
                    }
                } else {
                    require RUTA_VIEWS . 'zonas/confirmacion.php';
                }
            } else {
                $params['error'] = "El código de zona introducido no existe";
                require RUTA_VIEWS . 'zonas/formNomUsuarios.php';
            }
        }
    }

}
