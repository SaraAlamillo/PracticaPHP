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
            <td colspan="2">
    <input type="submit" value="Insertar" />
            </td>
        </tr>
    </table>
</form>