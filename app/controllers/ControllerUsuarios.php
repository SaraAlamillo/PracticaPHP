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
        if (! $_POST) {
            require RUTA_VIEWS . 'login.php';
        } else {
            if ($this->modelUsuarios->existeUsuario($_POST['nombre'], $_POST['clave'])) {
                $_SESSION['usuarioValidado'] = TRUE;
                $_SESSION['hora'] = date("H:m:s");
                header("Location: index.php?action=inicio");
            } else {
                echo 'mal';
            }
        }
    }
    
    public function salir() {
        session_destroy();
        header("Location: index.php");
    }
}
