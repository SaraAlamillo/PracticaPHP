<?php if (isset($params['mensaje'])): ?>
    <p><?= $params['mensaje'] ?></p>
<?php endif; ?>
<form action="index.php?action=paso2" method="POST">
    <p>Servidor: <input type="text" name="servidor" value="<?= $params['datos']['servidor'] ?>" required="required" /></p>
    <p>Base de datos: <input type="text" name="bd" value="<?= $params['datos']['bd'] ?>" required="required"  /></p>
    <p>Usuario: <input type="text" name="usuario" value="<?= $params['datos']['usuario'] ?>" required="required"  /></p>
    <p>
        Contraseña: <input type="password" name="clave" value="<?= $params['datos']['clave'] ?>" />
    </p>
    <input type="submit" value="Siguiente" />
</form>
