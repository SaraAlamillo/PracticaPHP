<?php
/**
 * Contiene diferentes funciones que emulan los diferentes controladores
 *
 * @author Sara
 */
class ControllerUsuarios {
    private $modelUsuarios;

    public function __construct() {
        $this->modelUsuarios = new ModelUsuarios();
    }

    public function acceder() {
        if (! isset($_SESSION['usuarioValidado'])) {
        if (! $_POST) {
            require RUTA_VIEWS . 'usuarios/login.php';
        } else {
            if ($this->modelUsuarios->existeUsuario($_POST['nombre'], "nombre", $_POST['clave'])) {
                $_SESSION['usuarioValidado'] = TRUE;
                $_SESSION['hora'] = date("H:m:s");
                if ($this->modelUsuarios->esAdministrador($_POST['nombre'], $_POST['clave'])) {
                    $_SESSION['admin'] = TRUE;
                }
                header("Location: index.php?action=inicio");
            } else {
                echo 'mal';
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
    
     private function paginar($accion, &$pagina, $condiciones = NULL) {
        define("MaxPagina", 2);

        if (empty($pagina)) {
            $inicio = 0;
            $pagina = 1;
        } else {
            $inicio = ($pagina - 1) * MaxPagina;
        }

        $params = [
            'datos' => $this->modelUsuarios->listarUsuarios($inicio . "," . MaxPagina),
            'action' => $accion,
            'paginaActual' => $pagina,
            'numeroDePaginas' => ceil(count($this->modelUsuarios->listarUsuarios()) / MaxPagina),
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
            require RUTA_VIEWS . 'usuarios/noDatos.php';
        } else {
            require RUTA_VIEWS . 'usuarios/listar.php';
        }
    }

    public function listarUsuarios() {
        $this->paginar($_GET['action'], $_GET['pagina']);
    }
    
   public function insertarUsuario() {
        $params = [
            "action" => $_GET['action'],
            "datos" => [
                'nombre' => '',
                'clave' => '',
                'rol' => ''
            ],
            "roles" => $this->modelUsuarios->obtenerRoles()
        ];

        if ($_POST) {
            if ($this->modelUsuarios->existeNombre($_POST['nombre'])) {
                $params['datos'] = [
                    'nombre' => $_POST['nombre'],
                    'clave' => $_POST['clave'],
                    'rol' => $_POST['rol']
                ];
            } else {
            $this->modelUsuarios->insertarUsuario($_POST);
            } 
        }

        require RUTA_VIEWS . 'usuarios/formInsertar.php';
    }
    
    public function eliminarUsuario(){
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
    
    public function modificarUsuario(){
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
