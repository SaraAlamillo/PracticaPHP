<?php
define("RUTA_ROOT", $_SERVER['DOCUMENT_ROOT'] . "/PracticaPHP/");
define("RUTA_APP", RUTA_ROOT . "App/");
define("RUTA_CONTROLLERS", RUTA_APP . "controllers/");
define("RUTA_LIBRARIES", RUTA_APP . "libraries/");
define("RUTA_MODELS", RUTA_APP . "models/");
define("RUTA_VIEWS", RUTA_APP . "views/");
define("URL_ROOT", "http://" . $_SERVER['SERVER_NAME'] . "/PracticaPHP/");
define("URL_CSS", URL_ROOT . "Assets/css/");
define("URL_IMAGES", URL_ROOT . "Assets/images/");
define("URL_JS", URL_ROOT . "Assets/js/");

// carga del modelo y los controladores
require_once RUTA_APP. 'Config.php';
require_once RUTA_MODELS . 'Model.php';
require_once RUTA_CONTROLLERS . 'Controller.php';

// enrutamiento
$map = array(
    'inicio' => array('controller' => 'Controller', 'action' => 'inicio'),
    'listar' => array('controller' => 'Controller', 'action' => 'listar'),
    'insertar' => array('controller' => 'Controller', 'action' => 'insertar'),
    'buscar' => array('controller' => 'Controller', 'action' => 'buscar'),
    'eliminar' => array('controller' => 'Controller', 'action' => 'eliminar'),
    'recepcionar' => array('controller' => 'Controller', 'action' => 'recepcionar'),
    'modificar' => array('controller' => 'Controller', 'action' => 'modificar')
);

// Parseo de la ruta
if (isset($_GET['action'])) {
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
    $ruta = 'inicio';
}

$controlador = $map[$ruta];
// Ejecución del controlador asociado a la ruta

if (method_exists($controlador['controller'], $controlador['action'])) {
    call_user_func(array(new $controlador['controller'], $controlador['action']));
} else {

    header('Status: 404 Not Found');
    echo '<html>'
    . '<body>'
    . '<h1>Error 404: El controlador <i>' . $controlador['controller'] . '->' . $controlador['action'] . '</i> no existe</h1>'
    . '</body>'
    . '</html>';
}