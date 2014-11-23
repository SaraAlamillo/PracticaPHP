<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Sara Alamillo Arroyo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href='<?= URL_CSS . Config::$css ?>' />

    </head>
    <body>
        <div id="cabecera">
            <h1>Administración de los Envíos</h1>
        </div>

        <div id="menu">
            <hr/>
            <a href="index.php?action=inicio">home</a> |
            <a href="index.php?action=listar">listar</a> |
            <a href="index.php?action=insertar">insertar</a> |
            <a href="index.php?action=buscar">buscar</a> |
            <a href="index.php?action=eliminar">eliminar</a> |
            <a href="index.php?action=recepcionar">anotar recepción</a> |
            <a href="index.php?action=modificar">modificar datos</a>
            <hr/>
        </div>

        <div id="contenido">
            <?= $contenido ?>
        </div>

        <div id="pie">
            <hr/>
            <div align="center">(: Sara Alamillo Arroyo :)</div>
        </div>
    </body>
</html>