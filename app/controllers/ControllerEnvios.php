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
            /* 'fecha_entrega' => array(
              'filter' => FILTER_CALLBACK,
              'options' => "TratamientoFormularios::fecha"),
              'fecha_creacion' => array(
              'filter' => FILTER_CALLBACK,
              'options' => "TratamientoFormularios::fecha") */
    );
    private $modelEnvios;
    private $modelProvincias;
    private $modelZonas;

    public function __construct() {
        $this->modelEnvios = new ModelEnvios();
        $this->modelProvincias = new ModelProvincias();
        $this->modelZonas = new ModelZonas();
    }

    public function inicio() {
        require RUTA_VIEWS . 'inicio.php';
    }

    public function listar() {
        paginar(
                $_GET['action'], $_GET['pagina'], $this->modelEnvios, "listarEnvios", $params
        );

        if ($params['datos'] == NULL) {
            require RUTA_VIEWS . 'envios/noDatos.php';
        } else {
            require RUTA_VIEWS . 'envios/listar.php';
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
                'observaciones' => '',
                'zona_envio' => $this->modelZonas->obtenerNombre($_SESSION['zona'])
            ],
            "provincias" => $this->modelProvincias->obtenerTodasProvincias()
        ];

        if ($_POST) {
            $_POST['zona_envio'] = $this->modelZonas->obtenerID($_POST['zona_envio']);
            $datosError = TratamientoFormularios::validarArray($this::$criterios);

            if (empty($datosError)) {
                if ($this->modelEnvios->insertarEnvio($_POST)) {
                    $params['mensaje'] = "Se han insertado los datos correctamente";
                } else {
                    $params['mensaje'] = "Ups... Algo ha fallado...";
                    $params['datos'] = $_POST;
                    $params['datos']['zona_envio'] = $this->modelZonas->obtenerNombre($_SESSION['zona']);
                }
            } else {
                $params['errores'] = $datosError;
                $params['mensaje'] = "Se han introducido valores no válidos";
                $params['datos'] = $_POST;
                $params['datos']['zona_envio'] = $this->modelZonas->obtenerNombre($_SESSION['zona']);
            }
        }

        require RUTA_VIEWS . 'envios/formInsertar.php';
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
            paginar($_GET['action'], $_GET['pagina'], $this->modelEnvios, "listarEnvios", $params, $_SESSION['criteriosBusqueda']);
            if ($params['datos'] == NULL) {
                require RUTA_VIEWS . 'envios/noDatos.php';
            } else {
                require RUTA_VIEWS . 'envios/listar.php';
            }
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

                require RUTA_VIEWS . 'envios/formBuscar.php';
            } else {
                $_SESSION['criteriosBusqueda'] = $datos;
                $this->paginar($_GET['action'], $_GET['pagina'], $_SESSION['criteriosBusqueda']);
            }
        } else {
            require RUTA_VIEWS . 'envios/formBuscar.php';
        }
    }

    public function eliminar() {
        $params = [
            "action" => $_GET['action']
        ];

        if (empty($_GET['id'])) {
            require RUTA_VIEWS . 'envios/formCodEnvio.php';
        } else {
            $params['id'] = $_GET['id'];
            if ($this->modelEnvios->existeEnvio($_GET['id'])) {
                if (isset($_GET['confirmacion'])) {
                    if ($_GET['confirmacion'] == "Si") {
                        if ($this->modelEnvios->eliminarEnvio($_GET['id'])) {
                            require RUTA_VIEWS . 'envios/finalBien.php';
                        } else {
                            require RUTA_VIEWS . 'envios/finalMal.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'envios/formCodEnvio.php';
                    }
                } else {
                    require RUTA_VIEWS . 'envios/confirmacion.php';
                }
            } else {
                $params['error'] = "El código de envío introducido no existe";
                require RUTA_VIEWS . 'envios/formCodEnvio.php';
            }
        }
    }

    public function recepcionar() {
        $params = [
            "action" => $_GET['action']
        ];

        if (empty($_GET['id'])) {
            require RUTA_VIEWS . 'envios/formCodEnvio.php';
        } else {
            $params['id'] = $_GET['id'];
            if ($this->modelEnvios->existeEnvio($_GET['id'])) {
                if ($this->modelEnvios->elementoRecepcionado($_GET['id'])) {
                    $params['error'] = "El envío introducido ya ha sido recepcionado";
                    require RUTA_VIEWS . 'envios/formCodEnvio.php';
                } else {
                    if (isset($_GET['confirmacion'])) {
                        $params['confirmacion'] = $_GET['confirmacion'];
                        if ($_GET['confirmacion'] == "Si") {
                            $datos = [
                                "fecha_entrega" => date("Y-m-d"),
                                "estado" => "Entregado",
                                "zona_recepcion" => $_SESSION['zona']
                            ];
                            if ($this->modelEnvios->modificarEnvio($_GET['id'], $datos)) {
                                require RUTA_VIEWS . 'envios/finalBien.php';
                            } else {
                                require RUTA_VIEWS . 'envios/finalMal.php';
                            }
                        } else {
                            require RUTA_VIEWS . 'envios/formCodEnvio.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'envios/confirmacion.php';
                    }
                }
            } else {
                $params['error'] = "El código de envío introducido no existe";
                require RUTA_VIEWS . 'envios/formCodEnvio.php';
            }
        }
    }

    public function modificar() {
        $params = [
            "action" => $_GET['action']
        ];

        if (empty($_GET['id'])) {
            require RUTA_VIEWS . 'envios/formCodEnvio.php';
        } else {
            $params['id'] = $_GET['id'];
            if ($this->modelEnvios->existeEnvio($_GET['id'])) {
                if (isset($_GET['confirmacion'])) {
                    $params['confirmacion'] = $_GET['confirmacion'];
                    if ($_GET['confirmacion'] == "Si") {
                        $params['provincias'] = $this->modelProvincias->obtenerTodasProvincias();
                        $params['estados'] = $this->modelEnvios->obtenerEstados();
                        $params['datos'] = $this->modelEnvios->listarUnEnvio($_GET['id']);
                        $params['datos']['zona_envio'] = $this->modelZonas->obtenerNombre($params['datos']['zona_envio']);
                        if (isset($params['datos']['zona_recepcion'])) {
                            $params['datos']['zona_recepcion'] = $this->modelZonas->obtenerNombre($params['datos']['zona_recepcion']);
                        }
                        if ($_POST) {
                            $_POST['zona_envio'] = $this->modelZonas->obtenerID($_POST['zona_envio']);
                            if (isset($_POST['zona_recepcion'])) {
                                $_POST['zona_recepcion'] = $this->modelZonas->obtenerID($_POST['zona_recepcion']);
                            }
                            $datosError = TratamientoFormularios::validarArray($this::$criterios);

                            if (empty($datosError)) {
                                if ($this->modelEnvios->modificarEnvio($_GET['id'], $_POST)) {
                                    require RUTA_VIEWS . 'envios/finalBien.php';
                                } else {
                                    $params['mensaje'] = "Ups... Algo ha fallado...";
                                    $params['datos'] = $_POST;
                                }
                            } else {
                                $params['errores'] = $datosError;
                                $params['mensaje'] = "Se han introducido valores no válidos";
                                $params['datos'] = $_POST;
                            }
                            require RUTA_VIEWS . 'envios/formModificar.php';
                        } else {
                            require RUTA_VIEWS . 'envios/formModificar.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'envios/formCodEnvio.php';
                    }
                } else {
                    require RUTA_VIEWS . 'envios/confirmacion.php';
                }
            } else {
                $params['error'] = "El código de envío introducido no existe";
                require RUTA_VIEWS . 'envios/formCodEnvio.php';
            }
        }
    }

}
