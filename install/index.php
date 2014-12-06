<?php
require_once RUTA_INSTALL . 'ControllerInstaller.php';
require_once RUTA_INSTALL . 'ModelInstaller.php';
require_once RUTA_LIBRARIES . 'DataBase.php';
require_once RUTA_LIBRARIES . 'Helper.php';

$map = [
    'paso1' => array('controller' => 'ControllerInstaller', 'action' => 'paso1'),
    'paso2' => array('controller' => 'ControllerInstaller', 'action' => 'paso2'),
    'paso3' => array('controller' => 'ControllerInstaller', 'action' => 'paso3'),
    'paso4' => array('controller' => 'ControllerInstaller', 'action' => 'paso4'),
    'paso5' => array('controller' => 'ControllerInstaller', 'action' => 'paso5')
];

// Parseo de la ruta
if (isset($_GET['action'])) {
    if (isset($map[$_GET['action']])) {
        $ruta = $_GET['action'];
    } else {
        header('Status: 404 Not Found');
        ?> 
        <html>
            <body>
                 <h1>Error 404: No existe la ruta <i><?=RUTA_ROOT ?>/<?=$_GET['action'] ?></i></h1>
            </body>
        </html>
        <?php
        exit;
    }
} else {
    $ruta = 'paso1';
}

$controlador = $map[$ruta];
// Ejecución del controlador asociado a la ruta

if (method_exists($controlador['controller'], $controlador['action'])) {
    ob_start();

    call_user_func(array(new $controlador['controller'], $controlador['action']));

    $contenido = ob_get_clean();
    $instalador = TRUE;

    include RUTA_VIEWS . "layout.php";
} else {
    header('Status: 404 Not Found');
    ?>
    <html>
        <body>
            <h1>Error 404: El controlador <i><?= $controlador['controller'] ?> -> <?= $controlador['action'] ?></i> no existe</h1>
        </body>
    </html>
    <?php
}
