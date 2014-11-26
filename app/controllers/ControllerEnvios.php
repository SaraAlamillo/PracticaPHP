<?php

/**
 * Contiene diferentes funciones que emulan los diferentes controladores
 *
 * @author Sara
 */
class ControllerEnvios {
    public static $criterios = array(
        'destinatario' => array(
            'filter' => FILTER_CALLBACK,
            'options' => "TratamientoFormularios::alfabetico"),
        'telefono' => array(
            'filter' => FILTER_CALLBACK,
            'options' => "TratamientoFormularios::numerico"),
        'direccion' => array(
            'filter' => FILTER_CALLBACK,
            'options' => "TratamientoFormularios::alfanumericoSimbolos"),
        'poblacion' => array(
            'filter' => FILTER_CALLBACK,
            'options' => "TratamientoFormularios::alfabetico"),
        'cod_postal' => array(
            'filter' => FILTER_CALLBACK,
            'options' => "TratamientoFormularios::cp"),
        'provincia' => array(
            'filter' => FILTER_CALLBACK,
            'options' => "TratamientoFormularios::provincias"),
        'email' => array(
            'filter' => FILTER_VALIDATE_EMAIL),
        'observaciones' => array(
            'filter' => FILTER_CALLBACK,
            'options' => "TratamientoFormularios::alfanumericoSimbolos"),
        /*'fecha_entrega' => array(
            'filter' => FILTER_CALLBACK,
            'options' => "TratamientoFormularios::fecha"),
        'fecha_creacion' => array(
            'filter' => FILTER_CALLBACK,
            'options' => "TratamientoFormularios::fecha")*/
    );
    private $modelEnvios;
    private $modelProvincias;

    public function __construct() {
        $this->modelEnvios = new ModelEnvios();
        $this->modelProvincias = new ModelProvincias();
    }

    public function inicio() {
        $params = [
            'mensaje' => 'Práctica 1ª Evaluación - Desarrollo Web en Entorno Servidor',
        ];

        require RUTA_VIEWS . 'inicio.php';
    }

    private function paginar($accion, &$pagina, $condiciones = NULL) {
        define("MaxPagina", 2);

        if (empty($pagina)) {
            $inicio = 0;
            $pagina = 1;
        } else {
            $inicio = ($pagina - 1) * MaxPagina;
        }

        $params = [
            'datos' => $this->modelEnvios->listarEnvios($condiciones, $inicio . "," . MaxPagina),
            'action' => $accion,
            'paginaActual' => $pagina,
            'numeroDePaginas' => ceil(count($this->modelEnvios->listarEnvios($condiciones)) / MaxPagina),
            'controlesActivos' => [
                'primero' => '',
                'anterior' => '',
                'siguiente' => '',
                'ultimo' => ''
            ]
        ];

        if ($pagina == 1) {
            $params['controlesActivos']['primero'] = "disabled='disabled'";
            $params['controlesActivos']['anterior'] = "disabled='disabled'";
        }
        if ($pagina == $params['numeroDePaginas']) {
            $params['controlesActivos']['siguiente'] = "disabled='disabled'";
            $params['controlesActivos']['ultimo'] = "disabled='disabled'";
        }

        if ($params['datos'] == NULL) {
            require RUTA_VIEWS . 'noDatos.php';
        } else {
            require RUTA_VIEWS . 'listar.php';
        }
    }

    public function listar() {
        $this->paginar($_GET['action'], $_GET['pagina']);
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
            "provincias" => $this->modelProvincias->obtenerTodasProvincias()
        ];

        if ($_POST) {
            $datosError = TratamientoFormularios::validarArray($this::$criterios);
            
            if (empty($datosError)){
            $this->modelEnvios->insertarEnvio($_POST);
            } else {
                echo "ok";
            }
        }

        require RUTA_VIEWS . 'formInsertar.php';
    }

    public function buscar() {
        $params = [
            "action" => $_GET['action'],
            "estados" => $this->modelEnvios->obtenerEstados(),
            "provincias" => $this->modelProvincias->obtenerTodasProvincias(),
            "tipo_busqueda" => $this->modelEnvios->obtenerTiposBusqueda()
        ];

        if (isset($_GET['nueva'])) {
            unset($_SESSION['criteriosBusqueda']);
        }

        if (isset($_SESSION['criteriosBusqueda'])) {
            $this->paginar($_GET['action'], $_GET['pagina'], $_SESSION['criteriosBusqueda']);
        } else if ($_POST) {
            $datos = [];
            $camposFormulario = $this->modelEnvios->obtenerCamposFormulario();

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
                $_SESSION['criteriosBusqueda'] = $datos;
                $this->paginar($_GET['action'], $_GET['pagina'], $_SESSION['criteriosBusqueda']);
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
            if ($this->modelEnvios->existeEnvio($_GET['id'])) {
                if (isset($_GET['confirmacion'])) {
                    if ($_GET['confirmacion'] == "Si") {
                        if ($this->modelEnvios->eliminarEnvio($_GET['id'])) {
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
            if ($this->modelEnvios->existeEnvio($_GET['id'])) {
                if (isset($_GET['confirmacion'])) {
                    $params['confirmacion'] = $_GET['confirmacion'];
                    if ($_GET['confirmacion'] == "Si") {
                        $datos = [
                            "fecha_entrega" => date("Y-m-d"),
                            "estado" => "E"
                        ];
                        if ($this->modelEnvios->modificarEnvio($_GET['id'], $datos)) {
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
            if ($this->modelEnvios->existeEnvio($_GET['id'])) {
                if (isset($_GET['confirmacion'])) {
                    $params['confirmacion'] = $_GET['confirmacion'];
                    if ($_GET['confirmacion'] == "Si") {
                        $params['provincias'] = $this->modelProvincias->obtenerTodasProvincias();
                        $params['estados'] = $this->modelEnvios->obtenerEstados();
                        $params['antiguo'] = $this->modelEnvios->listarUnEnvio($_GET['id']);
                        if ($_POST) {
                            if ($this->modelEnvios->modificarEnvio($_GET['id'], $_POST)) {
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