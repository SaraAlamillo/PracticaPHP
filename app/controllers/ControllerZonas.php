<?php
/**
 * Contiene diferentes funciones que emulan los diferentes controladores de la sección de zonas
 *
 * @author Sara
 */
class ControllerZonas {

    /**
     * Contiene el acceso al modelo para zonas
     * @var Object 
     */
    private $modelZonas;

    /**
     * Constructor de la clase ControllerZonas
     */
    public function __construct() {
        $this->modelZonas = new ModelZonas();
    }

    /**
     * Modifica la zona actual seleccionada por otra determinada por el usuario
     */
    public function cambiarZona() {
        if (isset($_POST['nuevaZona'])) {
            $_SESSION['zona'] = $_POST['nuevaZona'];
        }
        require RUTA_VIEWS . 'zonas/cambioZona.php';
    }

    /**
     * Lista todas las zonas recogidas en la aplicación
     */
    public function listarZonas() {
        Helper::paginar(
                $_GET['action'], $_GET['pagina'], $this->modelZonas, "listarZonas", $params
        );

        if ($params['datos'] == NULL) {
            require RUTA_VIEWS . 'noDatos.php';
        } else {
            require RUTA_VIEWS . 'zonas/listar.php';
        }
    }

    /**
     * Inserta una nueva zona en la aplicación
     */
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

    /**
     * Eliminar una zona determinada de la aplicación
     */
    public function eliminarZona() {
        $params = [
            "action" => $_GET['action'],
            "nomCampoID" => "codigo",
            "accion" => "eliminar la zona",
            "zonas" => $this->modelZonas->listarZonas()
        ];

        if (empty($_GET['codigo'])) {
            require RUTA_VIEWS . 'zonas/formNomZonas.php';
        } else {
            $params['codigo'] = $_GET['codigo'];
            if ($this->modelZonas->existeZona($_GET['codigo'])) {
                if ($this->modelZonas->zonaUtilizada($_GET['codigo'])) {
                    $params['error'] = "La zona introducida está siendo utilizada";
                    require RUTA_VIEWS . 'zonas/formNomZonas.php';
                } else {
                    if (isset($_GET['confirmacion'])) {
                        if ($_GET['confirmacion'] == "Si") {
                            if ($this->modelZonas->eliminarZona($_GET['codigo'])) {
                                require RUTA_VIEWS . 'finalBien.php';
                            } else {
                                require RUTA_VIEWS . 'finalMal.php';
                            }
                        } else {
                            require RUTA_VIEWS . 'zonas/formNomZonas.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'confirmacion.php';
                    }
                }
            } else {
                $params['error'] = "El nombre de zona introducido no existe";
                require RUTA_VIEWS . 'zonas/formNomZonas.php';
            }
        }
    }

    /**
     * Modifica el nombre de una zona determinada
     */
    public function modificarZona() {
        $params = [
            "action" => $_GET['action'],
            "nomCampoID" => "codigo",
            "accion" => "modificar los datos de la zona",
            "zonas" => $this->modelZonas->listarZonas()
        ];

        if (empty($_GET['codigo'])) {
            require RUTA_VIEWS . 'zonas/formNomZonas.php';
        } else {
            $params['codigo'] = $_GET['codigo'];
            if ($this->modelZonas->existeZona($_GET['codigo'])) {
                if (isset($_GET['confirmacion'])) {
                    $params['confirmacion'] = $_GET['confirmacion'];
                    if ($_GET['confirmacion'] == "Si") {
                        $params['antiguo'] = $this->modelZonas->listarUnaZona($_GET['codigo']);
                        if ($_POST) {
                            if ($this->modelZonas->modificarZona($_GET['codigo'], $_POST)) {
                                require RUTA_VIEWS . 'finalBien.php';
                            } else {
                                require RUTA_VIEWS . 'finalMal.php';
                            }
                        } else {
                            require RUTA_VIEWS . 'zonas/formModificar.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'zonas/formNomZonas.php';
                    }
                } else {
                    require RUTA_VIEWS . 'confirmacion.php';
                }
            } else {
                $params['error'] = "El código de zona introducido no existe";
                require RUTA_VIEWS . 'zonas/formNomZonas.php';
            }
        }
    }

}
