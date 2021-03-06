<?php

/**
 * Contiene diferentes funciones que emulan los diferentes controladores de la sección envíos
 *
 * @author Sara
 */
class ControllerEnvios {

    /**
     * Recoge los criterios para validar los diferentes campos en los formularios
     * @var Array 
     */
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
        'fecha_creacion' => array(
            'filter' => FILTER_CALLBACK,
            'options' => "TratamientoFormularios::fecha")
    );

    /**
     * Recoge el acceso al modelo para envíos
     * @var Object 
     */
    private $modelEnvios;

    /**
     * Recoge el acceso al modelo para provincias
     * @var Object 
     */
    private $modelProvincias;

    /**
     * Recoge el acceso al modelo para zonas
     * @var Object 
     */
    private $modelZonas;

    /**
     * Constructor de la clase ControllerEnvios
     */
    public function __construct() {
        $this->modelEnvios = new ModelEnvios();
        $this->modelProvincias = new ModelProvincias();
        $this->modelZonas = new ModelZonas();
    }

    /**
     * Muestra por pantalla la sección home de la aplicación
     */
    public function inicio() {
        require RUTA_VIEWS . 'inicio.php';
    }

    /**
     * Lista los envíos de forma paginada
     */
    public function listar() {
        Helper::paginar(
                $_GET['action'], $_GET['pagina'], $this->modelEnvios, "listarEnvios", $params
        );

        if ($params['datos'] == NULL) {
            require RUTA_VIEWS . 'noDatos.php';
        } else {
            require RUTA_VIEWS . 'envios/listar.php';
        }
    }

    /**
     * Valida e insertar envíos en la aplicación
     */
    public function insertar() {
        $params = [
            "action" => $_GET['action'],
            "datos" => [
                'destinatario' => '',
                'telefono' => '',
                'direccion' => '',
                'poblacion' => trim(configPlus::$valPorDefPoblacion),
                'cod_postal' => '',
                'provincia' => trim(configPlus::$valPorDefProvincia),
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

    /**
     * Busca envíos en la aplicación según unos criterios establecidos por el usuario
     */
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
            Helper::paginar($_GET['action'], $_GET['pagina'], $this->modelEnvios, "listarEnvios", $params, $_SESSION['criteriosBusqueda']);

            if ($params['datos'] == NULL) {
                require RUTA_VIEWS . 'noDatos.php';
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
                Helper::paginar($_GET['action'], $_GET['pagina'], $this->modelEnvios, "listarEnvios", $params, $_SESSION['criteriosBusqueda']);

                if ($params['datos'] == NULL) {
                    require RUTA_VIEWS . 'noDatos.php';
                } else {
                    require RUTA_VIEWS . 'envios/listar.php';
                }
            }
        } else {
            require RUTA_VIEWS . 'envios/formBuscar.php';
        }
    }

    /**
     * Elimina un envío de la aplicación, con previa confirmación
     */
    public function eliminar() {
        $params = [
            "action" => $_GET['action'],
            "accion" => "eliminar el envío",
            "nomCampoID" => "id"
        ];

        if (empty($_GET['id'])) {
            require RUTA_VIEWS . 'envios/formCodEnvio.php';
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
                        require RUTA_VIEWS . 'envios/formCodEnvio.php';
                    }
                } else {
                    require RUTA_VIEWS . 'confirmacion.php';
                }
            } else {
                $params['error'] = "El código de envío introducido no existe";
                require RUTA_VIEWS . 'envios/formCodEnvio.php';
            }
        }
    }

    /**
     * Modifica los datos de un envío para anotar su recepción
     */
    public function recepcionar() {
        $params = [
            "action" => $_GET['action'],
            "accion" => "anotar la recepción del envío",
            "nomCampoID" => "id"
        ];

        if (empty($_GET['id'])) {
            require RUTA_VIEWS . 'envios/formCodEnvio.php';
        } else {
            $params['id'] = $_GET['id'];
            if ($this->modelEnvios->existeEnvio($_GET['id'], TRUE)) {
                if ($this->modelEnvios->elementoRecepcionado($_GET['id'])) {
                    $params['error'] = "El envío introducido ya ha sido recepcionado";
                    require RUTA_VIEWS . 'envios/formCodEnvio.php';
                } else {
                    if (isset($_GET['confirmacion'])) {
                        $params['confirmacion'] = $_GET['confirmacion'];
                        if ($_GET['confirmacion'] == "Si") {
                            $params['datos'] = $this->modelEnvios->listarUnEnvio($_GET['id']);
                            $params['datos']["fecha_entrega"] = date("Y-m-d");
                            $params['datos']["estado"] = "Entregado";
                            $params['datos']["zona_recepcion"] = $_SESSION['zona'];
                            $params['datos']["zona_recepcion_nombre"] = $this->modelZonas->obtenerNombre($_SESSION['zona']);
                            $params['datos']['provincia_nombre'] = $params['datos']['provincia'];
                            $params['datos']['provincia'] = $this->modelProvincias->obtenerUnId($params['datos']['provincia']);
                            $params['datos']['zona_envio_nombre'] = $params['datos']['zona_envio'];
                            $params['datos']['zona_envio'] = $this->modelZonas->obtenerID($params['datos']['zona_envio']);
                            if ($_POST) {
                                
                                $datosError = TratamientoFormularios::validarArray($this::$criterios);

                                if (empty($datosError)) {


                                    if ($this->modelEnvios->modificarEnvio($_GET['id'], $_POST)) {
                                        require RUTA_VIEWS . 'finalBien.php';
                                    } else {
                                        $params['mensaje'] = "Ups... Algo ha fallado...";
                                        $_POST['zona_envio'] = $this->modelZonas->obtenerNombre($_POST['zona_envio']);
                                        $_POST['zona_recepcion'] = $this->modelZonas->obtenerNombre($_POST['zona_recepcion']);
                                        $_POST['provincia'] = $this->modelProvincias->obtenerUnNombre($_POST['provincia']);
                                        $params['datos'] = $_POST;
                                    }
                                } else {
                                    $params['errores'] = $datosError;
                                    $params['mensaje'] = "Se han introducido valores no válidos";
                                    $_POST['zona_envio'] = $this->modelZonas->obtenerNombre($_POST['zona_envio']);
                                    $_POST['zona_recepcion'] = $this->modelZonas->obtenerNombre($_POST['zona_recepcion']);
                                    $_POST['provincia'] = $this->modelProvincias->obtenerUnNombre($_POST['provincia']);
                                    $params['datos'] = $_POST;
                                    require RUTA_VIEWS . 'envios/formRecepcionar.php';
                                }
                            } else {
                                require RUTA_VIEWS . 'envios/formRecepcionar.php';
                            }
                        } else {
                            require RUTA_VIEWS . 'envios/formCodEnvio.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'confirmacion.php';
                    }
                }
            } else {
                $params['error'] = "El código de envío introducido no existe";
                require RUTA_VIEWS . 'envios/formCodEnvio.php';
            }
        }
    }

    /**
     * Actualiza los datos de un envío determinado por el usuario
     */
    public function modificar() {
        $params = [
            "action" => $_GET['action'],
            "accion" => "modificar los datos del envío",
            "nomCampoID" => "id"
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

                        if ($_POST) {
                            $datosError = TratamientoFormularios::validarArray($this::$criterios);

                            if (empty($datosError)) {
                                $_POST['zona_envio'] = $this->modelZonas->obtenerID($_POST['zona_envio']);
                                if (isset($_POST['zona_recepcion'])) {
                                    $_POST['zona_recepcion'] = $this->modelZonas->obtenerID($_POST['zona_recepcion']);
                                }
                                if ($this->modelEnvios->modificarEnvio($_GET['id'], $_POST)) {
                                    require RUTA_VIEWS . 'finalBien.php';
                                } else {
                                    $params['mensaje'] = "Ups... Algo ha fallado...";
                                    $params['datos'] = $_POST;
                                }
                            } else {
                                $params['errores'] = $datosError;
                                $params['mensaje'] = "Se han introducido valores no válidos";
                                $params['datos'] = $_POST;
                                require RUTA_VIEWS . 'envios/formModificar.php';
                            }
                        } else {
                            require RUTA_VIEWS . 'envios/formModificar.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'envios/formCodEnvio.php';
                    }
                } else {
                    require RUTA_VIEWS . 'confirmacion.php';
                }
            } else {
                $params['error'] = "El código de envío introducido no existe";
                require RUTA_VIEWS . 'envios/formCodEnvio.php';
            }
        }
    }

}
