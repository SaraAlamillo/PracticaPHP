<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Sara Alamillo Arroyo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?= CargaVista(
                RUTA_VIEWS . "encabezado.php", 
                [
                    'hora' => isset($_SESSION['hora'])? $_SESSION['hora'] : NULL, 
                    'validado' => isset($_SESSION['usuarioValidado'])? $_SESSION['usuarioValidado'] : NULL, 
                    'zona' => isset($_SESSION['zona'])? $_SESSION['zona'] : NULL,
                    'listadoZonas' => isset($listadoZonas)? $listadoZonas : NULL
                ]) 
        ?>
        <div id="contenido">
            <?= $contenido ?>
        </div>
        <?= CargaVista(RUTA_VIEWS . "pie.php") ?>
    </body>
</html>