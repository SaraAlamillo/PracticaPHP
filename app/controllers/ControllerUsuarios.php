<?php

/**
 * Contiene diferentes funciones que emulan los diferentes controladores
 *
 * @author Sara
 */
class ControllerUsuarios {

    private $modelUsuarios;
    private $modelZonas;

    public function __construct() {
        $this->modelUsuarios = new ModelUsuarios();
        $this->modelZonas = new ModelZonas();
    }

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
                            $_SESSION['hora'] = date("H:m:s");
                            $_SESSION['zona'] = $_POST['zona'];
                            if ($this->modelUsuarios->esAdministrador($_POST['nombre'], $_POST['clave'])) {
                                $_SESSION['admin'] = TRUE;
                            }
                            header("Location: index.php?action=inicio");
                        } else {
                            $params['mensaje'] = "La zona seleccionada no existe";
                            $params['datos'] = $_POST;
                            require RUTA_VIEWS . 'usuarios/login.php';
                        }
                    } else {
                        $params['mensaje'] = "Debe seleccionar una zona";
                        $params['datos'] = $_POST;
                        require RUTA_VIEWS . 'usuarios/login.php';
                    }
                } else {
                    $params['mensaje'] = "Usuario o contraseña incorrecta";
                    $params['datos'] = $_POST;
                    require RUTA_VIEWS . 'usuarios/login.php';
                }
            }
        } else {
            header("Location: index.php?action=inicio");
        }
    }

    public function salir() {
        session_destroy();
        header("Location: index.php");
    }

    public function listarUsuarios() {
        paginar(
                $_GET['action'], $_GET['pagina'], $this->modelUsuarios, "listarUsuarios", $params
        );

        if ($params['datos'] == NULL) {
            require RUTA_VIEWS . 'usuarios/noDatos.php';
        } else {
            require RUTA_VIEWS . 'usuarios/listar.php';
        }
    }

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

    public function eliminarUsuario() {
        $params = [
            "action" => $_GET['action'],
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
                            require RUTA_VIEWS . 'usuarios/finalBien.php';
                        } else {
                            require RUTA_VIEWS . 'usuarios/finalMal.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'usuarios/formNomUsuarios.php';
                    }
                } else {
                    require RUTA_VIEWS . 'usuarios/confirmacion.php';
                }
            } else {
                $params['error'] = "El nombre de usuario introducido no existe";
                require RUTA_VIEWS . 'usuarios/formNomUsuarios.php';
            }
        }
    }

    public function modificarUsuario() {
        $params = [
            "action" => $_GET['action'],
            "usuarios" => $this->modelUsuarios->listarUsuarios()
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
                        if ($_POST) {
                            $_POST['clave'] = sha1($_POST['clave']);
                            if ($this->modelUsuarios->modificarUsuario($_GET['usuario'], $_POST)) {
                                require RUTA_VIEWS . 'usuarios/finalBien.php';
                            } else {
                                require RUTA_VIEWS . 'usuarios/finalMal.php';
                            }
                        } else {
                            require RUTA_VIEWS . 'usuarios/formModificar.php';
                        }
                    } else {
                        require RUTA_VIEWS . 'usuarios/formNomUsuarios.php';
                    }
                } else {
                    require RUTA_VIEWS . 'usuarios/confirmacion.php';
                }
            } else {
                $params['error'] = "El código de envío introducido no existe";
                require RUTA_VIEWS . 'usuarios/formNomUsuarios.php';
            }
        }
    }

}
