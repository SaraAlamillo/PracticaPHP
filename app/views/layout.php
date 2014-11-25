<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Sara Alamillo Arroyo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href='<?= URL_CSS . Config::$css ?>' />

    </head>
    <body>
        <!-- Encabezado -->
        <?= CargaVista(RUTA_VIEWS . "encabezado.php") ?>
        <!-- Menú -->
        <?= CargaVista(RUTA_VIEWS . "menu.php") ?>
        
        <div id="contenido">
            <?= $contenido ?>
        </div>

        <!-- Pie -->
        <?= CargaVista(RUTA_VIEWS . "pie.php") ?>
    </body>
</html>