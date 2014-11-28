<?php if (isset($params['mensaje'])): ?>
<p><?=$params['mensaje'] ?></p>
<?php endif; ?>
<form action="index.php" method="post">
    Usuario: <input type="text" name="nombre" value="<?=$params['datos']['nombre'] ?>" />
    <br />
    Contraseña: <input type="password" name="clave" value="<?=$params['datos']['clave'] ?>" />
    <br />
    <input type="submit" />
</form>
