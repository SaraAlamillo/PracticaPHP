<?php if (isset($params['mensaje'])): ?>
    <p><?= $params['mensaje'] ?></p>
<?php endif; ?>
<form action="index.php?action=<?= $params['action'] ?>&id=<?= $params['id'] ?>&confirmacion=<?= $params['confirmacion'] ?>" method="POST">
    <table>
        <tr>
            <th>
                Código
            </th>
            <td>
                <input type="text" name="codigo" value="<?= $params['datos']['codigo'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['codigo'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>
                Destinatario
            </th>
            <td>
                <input type="text" name="destinatario" value="<?= $params['datos']['destinatario'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['destinatario'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td>
                <input type="tel" name="telefono" value="<?= $params['datos']['telefono'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['telefono'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Dirección</th>
            <td>
                <input type="text" name="direccion" value="<?= $params['datos']['direccion'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['direccion'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Población</th>
            <td>
                <input type="text" name="poblacion" value="<?= $params['datos']['poblacion'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['poblacion'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Código Postal</th>
            <td>
                <input type="text" name="cod_postal" value="<?= $params['datos']['cod_postal'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['cod_postal'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Provincia</th>
            <td>
                <input type="text" value="<?= $params['datos']['provincia_nombre'] ?>" readonly="readonly" />
                <input type="hidden" name="provincia" value="<?= $params['datos']['provincia'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['provincia'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Correo Electrónico</th>
            <td>
                <input type="email" name="email" value="<?= $params['datos']['email'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['email'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Estado</th>
            <td>
                <input type="text" name="estado" value="<?= $params['datos']['estado'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['estado'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Fecha de creación</th>
            <td>
                <input type="date" name="fecha_creacion" value="<?= $params['datos']['fecha_creacion'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['fecha_creacion'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Fecha de entrega</th>
            <td>
                <input type="date" name="fecha_entrega" value="<?= $params['datos']['fecha_entrega'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['fecha_entrega'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Observaciones</th>
            <td>
                <textarea name="observaciones"><?= $params['datos']['observaciones'] ?></textarea>
            </td>
            <?php if (isset($params['errores']['observaciones'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Zona de envío</th>
            <td>
                <input type="text" value="<?= $params['datos']['zona_envio_nombre'] ?>" readonly="readonly" />
                <input type="hidden" name="zona_envio" value="<?= $params['datos']['zona_envio'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['zona_envio'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <th>Zona de recepción</th>
            <td>
                <input type="text" value="<?= $params['datos']['zona_recepcion_nombre'] ?>" readonly="readonly" />
                <input type="hidden" name="zona_recepcion" value="<?= $params['datos']['zona_recepcion'] ?>" readonly="readonly" />
            </td>
            <?php if (isset($params['errores']['zona_recepcion'])): ?>
                <td>Valor incorrecto</td>
            <?php endif; ?>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Anotar recepción" />
            </td>
        </tr>
    </table>
</form>