<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Sara Alamillo Arroyo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href='<?= URL_CSS ?>estilo.css' />
        
    </head>
    <body>
        <?= CargaVista(
                RUTA_VIEWS . "encabezado.php", 
                [
                    'hora' => isset($_SESSION['hora'])? $_SESSION['hora'] : NULL, 
                    'usuario' => isset($_SESSION['nombreUsuario'])? $_SESSION['nombreUsuario'] : NULL, 
                    'validado' => isset($_SESSION['usuarioValidado'])? $_SESSION['usuarioValidado'] : NULL, 
                    'zona' => isset($_SESSION['zona'])? $_SESSION['zona'] : NULL,
                    'listadoZonas' => isset($listadoZonas)? $listadoZonas : NULL,
                    'instalador' => $instalador
                ]) 
        ?>
        <?php if (isset($_SESSION['usuarioValidado'])): ?>
            <?=CargaVista(RUTA_VIEWS . "menu.php"); ?>
        <?php if (isset($_SESSION['admin'])): ?>
            <?=CargaVista(RUTA_VIEWS . "menuAdministrador.php"); ?>
        <?php endif; ?>
        <?php endif; ?>
         

        <div id="contenido">
            <hr />
            <?= $contenido ?>
    <hr/>
        </div>

        <?= CargaVista(RUTA_VIEWS . "pie.php") ?>
        <script src="<?= URL_JS ?>paginacion.js"></script>
    </body>
</html>