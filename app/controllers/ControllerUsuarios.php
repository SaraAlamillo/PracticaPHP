<?php

/**
 * Contiene diferentes funciones que emulan los diferentes controladores de la sección de usuarios
 *
 * @author Sara
 */
class ControllerUsuarios {

    /**
     * Contiene el acceso al modelo para los usuarios
     * @var Object
     */
    private $modelUsuarios;

    /**
     * Contiene el acceso al modelo para las provincias
     * @var Object
     */
    private $modelProvincias;

    /**
     * Contiene el acceso al modelo para las zonas
     * @var Object
     */
    private $modelZonas;

    /**
     * Constructor para la clase ControllerUsuarios
     */
    public function __construct() {
        $this->modelUsuarios = new ModelUsuarios();
        $this->modelZonas = new ModelZonas();
        $this->modelProvincias = new ModelProvincias();
    }

    /**
     * Formulario para acceder a la aplicación, con previa validación.
     */
    public function acceder() {
        if (!isset($_SESSION['usuarioValidado'])) {
            $params = [
                "datos" => [
                    "nombre" => "",
                    "clave" => ""
                ],
                "zonas" => $this->modelZonas->listarZonas()
            ];

            if (!$_POST) {
                require RUTA_VIEWS . 'usuarios/login.php';
            } else {
                $_POST['clave'] = sha1($_POST['clave']);
                if ($this->modelUsuarios->existeUsuario($_POST['nombre'], "nombre", $_POST['clave'])) {

                    if ($_POST['zona'] != "0") {
                        if ($this->modelZonas->existeZona($_POST['zona'])) {
                            $_SESSION['usuarioValidado'] = TRUE;
                            $_SESSION['nombreUsuario'] = $_POST['nombre'];
                            $_SESSION['hora'] = time();
                            $_SESSION['zona'] = $_POST['zona'];
                            if ($this->modelUsuarios->esAdministrador($_POST['nombre'], $_POST['clave'])) {
                                $_SESSION['admin'] = TRUE;
                            }
                            header("Location: index.php?action=inicio");
                        } else {
                            $params['mensaje'] = "La zona seleccionada no existe";
                            $params['datos'] = $_POST;
                            $params['datos']['clave'] = "";
                            require RUTA_VIEWS . 'usuarios/login.php';
                        }
                    } else {
                        $params['mensaje'] = "Debe seleccionar una zona";
                        $params['datos'] = $_POST;
                        $params['datos']['clave'] = "";
                        require RUTA_VIEWS . 'usuarios/login.php';
                    }
                } else {
                    $params['mensaje'] = "Usuario o contraseña incorrecta";
                    $params['datos'] = $_POST;
                    $params['datos']['clave'] = "";

                    require RUTA_VIEWS . 'usuarios/login.php';
                }
            }
        } else {
            header("Location: index.php?action=inicio");
        }
    }

    /**
     * Destruye la sesión y redirecciona a la página principal
     */
    public function salir() {
        session_destroy();
        header("Location: index.php");
    }

    /**
     * Muestra un listado de todos los usuarios existentes en la aplicación
     */
    public function listarUsuarios() {
        Helper::paginar(
                $_GET['action'], $_GET['pagina'], $this->modelUsuarios, "listarUsuarios", $params
        );

        if ($params['datos'] == NULL) {
            require RUTA_VIEWS . 'noDatos.php';
        } else {
            require RUTA_VIEWS . 'usuarios/listar.php';
        }
    }

    /**
     * Valida e inserta un nuevo usuario
     */
    public function insertarUsuario() {
        $params = [
            "action" => $_GET['action'],
            "datos" => [
                'nombre' => '',
                'clave' => '',
                'rol' => 'Usuario'
            ],
            "roles" => $this->modelUsuarios->obtenerRoles()
        ];

        if ($_POST) {
            if ($this->modelUsuarios->existeUsuario($_POST['nombre'], "nombre")) {
                $params['datos'] = $_POST;
                $params['mensaje'] = "El nombre de usuario {$_POST['nombre']} ya existe en la base de datos";
            } else {
                $_POST['clave'] = sha1($_POST['clave']);
                if ($this->modelUsuarios->insertarUsuario($_POST)) {
                    $params['mensaje'] = "Usuario añadido correctamente";
                } else {
                    $params['datos'] = $_POST;
                    $params['mensaje'] = "Ups...Algo ha fallado";
                }
            }
        }

        require RUTA_VIEWS . 'usuarios/formInsertar.php';
    }

    /**
     * Elimina un usuario de la aplicación, previa confirmación
     */
    public function eliminarUsuario() {
        $params = [
            "action" => $_GET['action'],
            "accion" => "eliminar el usuario",
            "nomCampoID" => "usuario",
            "usuarios" => $this->modelUsuarios->listarUsuarios()
        ];

        if (empty($_GET['usuario'])) {
            require RUTA_VIEWS . 'usuarios/formNomUsuarios.php';
        } else {
            $params['usuario'] = $_GET['usuario'];
            if ($this->modelUsuarios->existeUsuario($_GET['usuario'], "codigo")) {
                if (isset($_GET['confirmacion'])) {
                    if ($_GET['confirmacion'] == "Si") {
                        if ($this->modelUsuarios->eliminarUsuario($_GET['usuario'])) {
                            require RUTA_VIEWS . 'finalBien.php';
                        } else {
                            require RUTA_VIEWS . 'finalMal.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'usuarios/formNomUsuarios.php';
                    }
                } else {
                    require RUTA_VIEWS . 'confirmacion.php';
                }
            } else {
                $params['error'] = "El nombre de usuario introducido no existe";
                require RUTA_VIEWS . 'usuarios/formNomUsuarios.php';
            }
        }
    }

    /**
     * Actualizar los datos de un usuario determinado
     */
    public function modificarUsuario() {
        $params = [
            "action" => $_GET['action'],
            "nomCampoID" => "usuario",
            "accion" => "modificar los datos del usuario",
            "usuarios" => $this->modelUsuarios->listarUsuarios(),
            "roles" => $this->modelUsuarios->obtenerRoles()
        ];

        if (empty($_GET['usuario'])) {
            require RUTA_VIEWS . 'usuarios/formNomUsuarios.php';
        } else {
            $params['usuario'] = $_GET['usuario'];
            if ($this->modelUsuarios->existeUsuario($_GET['usuario'], "codigo")) {
                if (isset($_GET['confirmacion'])) {
                    $params['confirmacion'] = $_GET['confirmacion'];
                    if ($_GET['confirmacion'] == "Si") {
                        $params['antiguo'] = $this->modelUsuarios->listarUnUsuario($_GET['usuario']);
                        $params['antiguo']['clave'] = "";
                        if ($_POST) {
                            if ($_POST['clave'] != "") {
                                $_POST['clave'] = sha1($_POST['clave']);
                            } else {
                                unset($_POST['clave']);
                            }
                            if ($this->modelUsuarios->modificarUsuario($_GET['usuario'], $_POST)) {
                                require RUTA_VIEWS . 'finalBien.php';
                            } else {
                                require RUTA_VIEWS . 'finalMal.php';
                            }
                        } else {
                            require RUTA_VIEWS . 'usuarios/formModificar.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'usuarios/formNomUsuarios.php';
                    }
                } else {
                    require RUTA_VIEWS . 'confirmacion.php';
                }
            } else {
                $params['error'] = "El código de envío introducido no existe";
                require RUTA_VIEWS . 'usuarios/formNomUsuarios.php';
            }
        }
    }

    /**
     * Carga el formulario para configurar parámetros en la aplicación
     */
    public function configParametros() {
        $params = [
            "action" => $_GET['action'],
            "provincias" => $this->modelProvincias->obtenerTodasProvincias(),
            "antiguo" => [
                "tiempoSesion" => trim(configPlus::$tiempoSesion),
                "defecto" => [
                    "provincia" => trim(configPlus::$valPorDefProvincia),
                    "poblacion" => trim(configPlus::$valPorDefPoblacion)
                ],
                "elemPag" => trim(configPlus::$elemPag)
            ]
        ];

        if ($_POST) {
            if ($_POST['medida'] == "horas") {
                $_POST['tiempoSesion'] *= 3600;
            } elseif ($_POST['medida'] == "minutos") {
                $_POST['tiempoSesion'] *= 60;
            }
            $fichero = fopen(RUTA_APP . "configPlus.php", "w");
            fwrite($fichero, "<?php\n");
            fwrite($fichero, "\n");
            fwrite($fichero, "/**\n");
            fwrite($fichero, "* Configuración de los parámetros adicionales de la aplicación\n");
            fwrite($fichero, "*\n");
            fwrite($fichero, "* @author Sara\n");
            fwrite($fichero, "*/\n");
            fwrite($fichero, "class configPlus {\n");
            fwrite($fichero, "/**\n");
            fwrite($fichero, "* Tiempo de duración de cada sesión\n");
            fwrite($fichero, "*/\n");
            fwrite($fichero, "static public \$tiempoSesion = \"{$_POST['tiempoSesion']}\n");
            fwrite($fichero, "\";\n");
            fwrite($fichero, "\n");
            fwrite($fichero, "/**\n");
            fwrite($fichero, "* Valores por defecto para el campo provincia de los formularios\n");
            fwrite($fichero, "*/\n");
            fwrite($fichero, "static public \$valPorDefProvincia = \"{$_POST['provincia']}\n");
            fwrite($fichero, "\";\n");
            fwrite($fichero, "/**\n");
            fwrite($fichero, "* Valores por defecto para el campo poblacion de los formularios\n");
            fwrite($fichero, "*/\n");
            fwrite($fichero, "static public \$valPorDefPoblacion = \"{$_POST['poblacion']}\n");
            fwrite($fichero, "\";\n");
            fwrite($fichero, "/**\n");
            fwrite($fichero, "* Máximo de elementos por página en las listas paginadas\n");
            fwrite($fichero, "*/\n");
            fwrite($fichero, "static public \$elemPag = \"{$_POST['elemPag']}\n");
            fwrite($fichero, "\";\n");
            fwrite($fichero, "}\n");

            $params = [
                "action" => $_GET['action'],
                "provincias" => $this->modelProvincias->obtenerTodasProvincias(),
                'mensaje' => "Configuración almacenada correctamente",
                'antiguo' => [
                    'tiempoSesion' => $_POST['tiempoSesion'],
                    'defecto' => [
                        'provincia' => $_POST['provincia'],
                        'poblacion' => $_POST['poblacion']
                    ],
                    'elemPag' => $_POST['elemPag']
                ]
            ];
        }
        require RUTA_VIEWS . 'parametros.php';
    }

}
