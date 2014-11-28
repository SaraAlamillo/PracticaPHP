<form action="index.php?action=<?= $params['action'] ?>&id=<?= $params['id'] ?>&confirmacion=<?= $params['confirmacion'] ?>" method="POST">
    <table>
        <tr>
            <th>
                Código
            </th>
            <td>
                <input type="text" name="codigo" value="<?= $params['antiguo']['codigo'] ?>" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <th>
                Destinatario
            </th>
            <td>
                <input type="text" name="destinatario" value="<?= $params['antiguo']['destinatario'] ?>" />
            </td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td>
                <input type="tel" name="telefono" value="<?= $params['antiguo']['telefono'] ?>" />
            </td>
        </tr>
        <tr>
            <th>Dirección</th>
            <td>
                <input type="text" name="direccion" value="<?= $params['antiguo']['direccion'] ?>" />
            </td>
        </tr>
        <tr>
            <th>Población</th>
            <td>
                <input type="text" name="poblacion" value="<?= $params['antiguo']['poblacion'] ?>" />
            </td>
        </tr>
        <tr>
            <th>Código Postal</th>
            <td>
                <input type="text" name="cod_postal" value="<?= $params['antiguo']['cod_postal'] ?>" />
            </td>
        </tr>
        <tr>
            <th>Provincia</th>
            <td>
                <?= creaListaDesplegable("provincia", $params['provincias'], $params['antiguo']['provincia']) ?>
            </td>
        </tr>
        <tr>
            <th>Correo Electrónico</th>
            <td>
                <input type="email" name="email" value="<?= $params['antiguo']['email'] ?>" />
            </td>
        </tr>
        <tr>
            <th>Estado</th>
            <td>
                <?= creaListaDesplegable("estado", $params['estados'], $params['antiguo']['estado']) ?>
            </td>
        </tr>
        <tr>
            <th>Fecha de creación</th>
            <td>
                <input type="date" name="fecha_creacion" value="<?= $params['antiguo']['fecha_creacion'] ?>" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <th>Fecha de entrega</th>
            <td>
                <input type="date" name="fecha_entrega" value="<?= $params['antiguo']['fecha_entrega'] ?>" />
            </td>
        </tr>
        <tr>
            <th>Observaciones</th>
            <td>
                <textarea name="observaciones"><?= $params['antiguo']['observaciones'] ?></textarea>
            </td>
        </tr>
    </table>
    <input type="submit" value="<?= $params['action'] ?>" />
</form>