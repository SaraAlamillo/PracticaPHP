<?php

include RUTA_VIEWS . 'helper.php';

/**
 * Contiene diferentes funciones que emulan los diferentes controladores
 *
 * @author Sara
 */
class Controller {

    private $model;

    public function __construct() {
        $this->model = new Model();
    }

    public function inicio() {
        $params = [
            'mensaje' => 'Práctica 1ª Evaluación - Desarrollo Web en Entorno Servidor',
        ];

        require RUTA_VIEWS . 'inicio.php';
    }

// TODO: implementar la paginación
    public function listar($condiciones = NULL) {
        $params = $this->model->listarEnvios($condiciones);

        if ($params == NULL) {
            require RUTA_VIEWS . 'noDatos.php';
        } else {
            require RUTA_VIEWS . 'listar.php';
        }
    }

    public function insertar() {
        $params = [
            "action" => $_GET['action'],
            "datos" => [
                'destinatario' => '',
                'telefono' => '',
                'direccion' => '',
                'poblacion' => '',
                'cod_postal' => '',
                'provincia' => '',
                'email' => '',
                'estado' => 'Pendiente',
                'fecha_creacion' => date("Y-m-d"),
                'observaciones' => ''
            ],
            "provincias" => $this->model->obtenerTodasProvincias()
        ];

        if ($_POST) {
            $this->model->insertarEnvio($_POST);
        }

        require RUTA_VIEWS . 'formInsertar.php';
    }

    public function buscar() {
        $params = [
            "action" => $_GET['action'],
            "estados" => $this->model->obtenerEstados(),
            "provincias" => $this->model->obtenerTodasProvincias(),
            "tipo_busqueda" => $this->model->obtenerTiposBusqueda()
        ];

        if ($_POST) {
            $datos = [];
            $camposFormulario = $this->model->obtenerCamposFormulario();

            foreach ($_POST as $clavePOST => $valorPOST) {
                if (in_array($clavePOST, $camposFormulario)) {
                    if ($_POST["valor$clavePOST"] != NULL && $_POST["valor$clavePOST"] != "" && $_POST["valor$clavePOST"] != "0") {
                        $datos[] = [
                            "campo" => $clavePOST,
                            "conector" => $_POST["tipo$clavePOST"],
                            "valor" => $_POST["valor$clavePOST"]
                        ];
                    }
                }
            }

            if (empty($datos)) {
                $params['mensaje'] = "No se ha introducido ningún criterio de búsqueda.";
                
                require RUTA_VIEWS . 'formBuscar.php';
            } else {
             $this->listar($datos);
            }
        } else {
            require RUTA_VIEWS . 'formBuscar.php';
        }
    }

    public function eliminar() {
        $params = [
            "action" => $_GET['action']
        ];

        if (empty($_GET['id'])) {
            require RUTA_VIEWS . 'formCodEnvio.php';
        } else {
            $params['id'] = $_GET['id'];
            if ($this->model->existeEnvio($_GET['id'])) {
                if (isset($_GET['confirmacion'])) {
                    if ($_GET['confirmacion'] == "Si") {
                        if ($this->model->eliminarEnvio($_GET['id'])) {
                            require RUTA_VIEWS . 'finalBien.php';
                        } else {
                            require RUTA_VIEWS . 'finalMal.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'formCodEnvio.php';
                    }
                } else {
                    require RUTA_VIEWS . 'confirmacion.php';
                }
            } else {
                $params['error'] = "El código de envío introducido no existe";
                require RUTA_VIEWS . 'formCodEnvio.php';
            }
        }
    }

    public function recepcionar() {
        $params = [
            "action" => $_GET['action']
        ];

        if (empty($_GET['id'])) {
            require RUTA_VIEWS . 'formCodEnvio.php';
        } else {
            $params['id'] = $_GET['id'];
            if ($this->model->existeEnvio($_GET['id'])) {
                if (isset($_GET['confirmacion'])) {
                    $params['confirmacion'] = $_GET['confirmacion'];
                    if ($_GET['confirmacion'] == "Si") {
                        $datos = [
                            "fecha_entrega" => date("Y-m-d"),
                            "estado" => "E"
                        ];
                        if ($this->model->modificarEnvio($_GET['id'], $datos)) {
                            require RUTA_VIEWS . 'finalBien.php';
                        } else {
                            require RUTA_VIEWS . 'finalMal.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'formCodEnvio.php';
                    }
                } else {
                    require RUTA_VIEWS . 'confirmacion.php';
                }
            } else {
                $params['error'] = "El código de envío introducido no existe";
                require RUTA_VIEWS . 'formCodEnvio.php';
            }
        }
    }

    public function modificar() {
        $params = [
            "action" => $_GET['action']
        ];

        if (empty($_GET['id'])) {
            require RUTA_VIEWS . 'formCodEnvio.php';
        } else {
            $params['id'] = $_GET['id'];
            if ($this->model->existeEnvio($_GET['id'])) {
                if (isset($_GET['confirmacion'])) {
                    $params['confirmacion'] = $_GET['confirmacion'];
                    if ($_GET['confirmacion'] == "Si") {
                        $params['provincias'] = $this->model->obtenerTodasProvincias();
                        $params['estados'] = $this->model->obtenerEstados();
                        $params['antiguo'] = $this->model->listarUnEnvio($_GET['id']);
                        if ($_POST) {
                            if ($this->model->modificarEnvio($_GET['id'], $_POST)) {
                                require RUTA_VIEWS . 'finalBien.php';
                            } else {
                                require RUTA_VIEWS . 'finalMal.php';
                            }
                        } else {
                            require RUTA_VIEWS . 'formModificar.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'formCodEnvio.php';
                    }
                } else {
                    require RUTA_VIEWS . 'confirmacion.php';
                }
            } else {
                $params['error'] = "El código de envío introducido no existe";
                require RUTA_VIEWS . 'formCodEnvio.php';
            }
        }
    }

}
