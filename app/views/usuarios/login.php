<?php if (isset($params['mensaje'])): ?>
    <p><?= $params['mensaje'] ?></p>
<?php endif; ?>
<form action="index.php" method="post">
    Usuario: <input type="text" name="nombre" value="<?= $params['datos']['nombre'] ?>" />
    <br />
    Contraseña: <input type="password" name="clave" value="<?= $params['datos']['clave'] ?>" />
    <br />
    Zona: <?=
    Helper::creaListaDesplegable(
            "zona", $params['zonas'], isset($params['datos']['zona']) ? $params['datos']['zona'] : "0", ['nombre' => "--Seleccionar--", "codigo" => "0"]
    )
    ?>
    <input type="submit" value="Acceder" />
</form>
