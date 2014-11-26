<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Sara Alamillo Arroyo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href='<?= URL_CSS . Config::$css ?>' />

    </head>
    <body>
        <?= CargaVista(RUTA_VIEWS . "encabezado.php", ['hora' => isset($_SESSION['hora'])? $_SESSION['hora'] : NULL, 'validado' => isset($_SESSION['usuarioValidado'])? $_SESSION['usuarioValidado'] : NULL]) ?>
        <?php
        if (isset($_SESSION['usuarioValidado'])) {
            CargaVista(RUTA_VIEWS . "menu.php");
        }
        ?>

        <div id="contenido">
            <?= $contenido ?>
        </div>

        <?= CargaVista(RUTA_VIEWS . "pie.php") ?>
    </body>
</html>