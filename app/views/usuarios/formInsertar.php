<?php if (isset($params['mensaje'])): ?>
<p><?=$params['mensaje'] ?></p>
<?php endif; ?>
<form action="index.php?action=<?= $params['action'] ?>" method="POST">
    <table>
        <tr>
            <th>Nombre</th>
            <td>
                <input type="text" name="nombre" value="<?= $params["datos"]['nombre'] ?>" />
            </td>
        </tr>
        <tr>
            <th>Contraseña</th>
            <td>
                <input type="password" name="clave" value="<?= $params["datos"]['clave'] ?>" />
            </td>
        </tr>
        <tr>
            <th>Rol</th>
            <td>
                <?= Helper::creaListaDesplegable("rol", $params['roles'], $params["datos"]['rol']) ?>
            </td>
        </tr>
    </table>
    <input type="submit" value="Insertar" />
</form>