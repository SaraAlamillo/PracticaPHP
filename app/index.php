<?php
// Comienza la sesión
session_name('envios');
session_start();

// Definición de rutas
define("RUTA_ROOT", __DIR__ . "/../");
define("RUTA_APP", RUTA_ROOT . "App/");
define("RUTA_CONTROLLERS", RUTA_APP . "controllers/");
define("RUTA_LIBRARIES", RUTA_APP . "libraries/");
define("RUTA_MODELS", RUTA_APP . "models/");
define("RUTA_VIEWS", RUTA_APP . "views/");
define("RUTA_INSTALL", RUTA_ROOT . "install/");
$rutaActual = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
$sinFichero = substr($rutaActual, 0, strrpos($rutaActual, "/"));
define("URL_ROOT", $sinFichero . "/../");
define("URL_CSS", URL_ROOT . "Assets/css/");
define("URL_IMAGES", URL_ROOT . "Assets/images/");
define("URL_JS", URL_ROOT . "Assets/js/");

// Si no hay configuración, salta automáticamente el instalador
if (!file_exists("Config.php")) {
    require_once RUTA_INSTALL . "index.php";
} else {
    //Si se acaba de terminar la instalación, se eliminan los rastros en las variables GET
    if (isset($_GET['finalizar']) && $_GET['action'] == "paso6" && $_GET['finalizar'] == "Finalizar") {
        unset($_GET['action']);
        unset($_GET['finalizar']);
    }

    //Carga de los controladores, modelos, librerías y configuración
    require_once RUTA_APP . 'Config.php';
    require_once RUTA_APP . 'configPlus.php';
    require_once RUTA_MODELS . 'ModelEnvios.php';
    require_once RUTA_MODELS . 'ModelProvincias.php';
    require_once RUTA_MODELS . 'ModelUsuarios.php';
    require_once RUTA_MODELS . 'ModelZonas.php';
    require_once RUTA_CONTROLLERS . 'ControllerEnvios.php';
    require_once RUTA_CONTROLLERS . 'ControllerUsuarios.php';
    require_once RUTA_CONTROLLERS . 'ControllerZonas.php';
    require_once RUTA_LIBRARIES . 'validacion.php';
    require_once RUTA_LIBRARIES . 'DataBase.php';
    require_once RUTA_LIBRARIES . 'Helper.php';

// Comprobación del último acceso a la aplicación para saber si se ha excedido el tiempo de conexión
    if (isset($_SESSION['ultimoAcceso']) && (time() - $_SESSION['ultimoAcceso']) > configPlus::$tiempoSesion) {
        session_destroy();
    }

    $_SESSION['ultimoAcceso'] = time();

    //Enrutamiento
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
        'modificarUsuario' => array('controller' => 'ControllerUsuarios', 'action' => 'modificarUsuario'),
        'cambiarZona' => array('controller' => 'ControllerZonas', 'action' => 'cambiarZona'),
        'insertarZona' => array('controller' => 'ControllerZonas', 'action' => 'insertarZona'),
        'listarZonas' => array('controller' => 'ControllerZonas', 'action' => 'listarZonas'),
        'eliminarZona' => array('controller' => 'ControllerZonas', 'action' => 'eliminarZona'),
        'modificarZona' => array('controller' => 'ControllerZonas', 'action' => 'modificarZona'),
        'configParametros' => array('controller' => 'ControllerUsuarios', 'action' => 'configParametros')
    ];

    // Parseo de la ruta
    if (isset($_GET['action']) && isset($_SESSION['usuarioValidado'])) {
        if (isset($map[$_GET['action']])) {
            $ruta = $_GET['action'];
        } else {
            header('Status: 404 Not Found');
            ?>
            <html>
                <body>
                    <h1>Error 404: No existe la ruta <i><?= RUTA_ROOT ?>/<?= $_GET['action'] ?></i></h1>
                </body>
            </html>
            <?php
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

        $listadoZonas = call_user_func(array(new ModelZonas(), "listarZonas"));
        $instalador = FALSE;
        isset($_SESSION['hora']) ? $hora = date("H:m:s", $_SESSION['hora']) : NULL;
        include RUTA_VIEWS . 'layout.php';
    } else {
        header('Status: 404 Not Found');
        ?>
        <html>
            <body>
                <h1>Error 404: El controlador <i><?= $controlador['controller'] ?>-><?= $controlador['action'] ?></i> no existe</h1>
            </body>
        </html>
        <?php
    }
}