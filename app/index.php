<?php

session_name('envios');
session_start();

define("RUTA_ROOT", $_SERVER['DOCUMENT_ROOT'] . "/PracticaPHP/");
define("RUTA_APP", RUTA_ROOT . "App/");
define("RUTA_CONTROLLERS", RUTA_APP . "controllers/");
define("RUTA_LIBRARIES", RUTA_APP . "libraries/");
define("RUTA_MODELS", RUTA_APP . "models/");
define("RUTA_VIEWS", RUTA_APP . "views/");
define("RUTA_HELPER", RUTA_APP . "helper/");
define("URL_ROOT", "http://" . $_SERVER['SERVER_NAME'] . "/PracticaPHP/");
define("URL_CSS", URL_ROOT . "Assets/css/");
define("URL_IMAGES", URL_ROOT . "Assets/images/");
define("URL_JS", URL_ROOT . "Assets/js/");

// carga del modelo y los controladores
require_once RUTA_APP . 'Config.php';
require_once RUTA_MODELS . 'ModelEnvios.php';
require_once RUTA_MODELS . 'ModelProvincias.php';
require_once RUTA_MODELS . 'ModelUsuarios.php';
require_once RUTA_CONTROLLERS . 'ControllerEnvios.php';
require_once RUTA_CONTROLLERS . 'ControllerUsuarios.php';
require_once RUTA_LIBRARIES . 'validacion.php';
require_once RUTA_LIBRARIES . 'DataBase.php';
require_once RUTA_HELPER . 'formularios.php';
require_once RUTA_HELPER . 'plantillas.php';


// enrutamiento
$map = [
    'inicio' => array('controller' => 'ControllerEnvios', 'action' => 'inicio'),
    'listar' => array('controller' => 'ControllerEnvios', 'action' => 'listar'),
    'insertar' => array('controller' => 'ControllerEnvios', 'action' => 'insertar'),
    'buscar' => array('controller' => 'ControllerEnvios', 'action' => 'buscar'),
    'eliminar' => array('controller' => 'ControllerEnvios', 'action' => 'eliminar'),
    'recepcionar' => array('controller' => 'ControllerEnvios', 'action' => 'recepcionar'),
    'modificar' => array('controller' => 'ControllerEnvios', 'action' => 'modificar'),
    'login' => array('controller' => 'ControllerUsuarios', 'action' => 'acceder'),
    'salir' => array('controller' => 'ControllerUsuarios', 'action' => 'salir'),
    'listarUsuarios' => array('controller' => 'ControllerUsuarios', 'action' => 'listarUsuarios'),
    'insertarUsuario' => array('controller' => 'ControllerUsuarios', 'action' => 'insertarUsuario'),
    'eliminarUsuario' => array('controller' => 'ControllerUsuarios', 'action' => 'eliminarUsuario'),
    'modificarUsuario' => array('controller' => 'ControllerUsuarios', 'action' => 'modificarUsuario')
];

// Parseo de la ruta
if (isset($_GET['action']) && isset($_SESSION['usuarioValidado'])) {
    if (isset($map[$_GET['action']])) {
        $ruta = $_GET['action'];
    } else {
        header('Status: 404 Not Found');
        echo '<html>'
        . '<body>'
        . '<h1>Error 404: No existe la ruta <i>' . RUTA_ROOT . '/' . $_GET['action'] . '</i></h1>'
        . '</body>'
        . '</html>';
        exit;
    }
} else {
    $ruta = 'login';
}

$controlador = $map[$ruta];
// Ejecución del controlador asociado a la ruta

if (method_exists($controlador['controller'], $controlador['action'])) {
    ob_start();

    call_user_func(array(new $controlador['controller'], $controlador['action']));

    $contenido = ob_get_clean();
    include RUTA_VIEWS . 'layout.php';
} else {
    header('Status: 404 Not Found');
    echo '<html>'
    . '<body>'
    . '<h1>Error 404: El controlador <i>' . $controlador['controller'] . '->' . $controlador['action'] . '</i> no existe</h1>'
    . '</body>'
    . '</html>';
}