<?php if (isset($params['mensaje'])): ?>
<p><?=$params['mensaje'] ?></p>
<?php endif; ?>
<form action="index.php?action=insertar" method="POST">
    <table>
            <tr>
                <th>
                    Destinatario
                </th>
                <td>
                    <input type="text" name="destinatario" value="<?= $params["datos"]['destinatario'] ?>" />
                </td>
                <?php if (isset($params['errores']['destinatario'])): ?>
                <td>Valor incorrecto</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>Teléfono</th>
                <td>
                    <input type="tel" name="telefono" value="<?= $params["datos"]['telefono'] ?>" />
                </td>
                <?php if (isset($params['errores']['telefono'])): ?>
                <td>Valor incorrecto</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>Dirección</th>
                <td>
                    <input type="text" name="direccion" value="<?= $params["datos"]['direccion'] ?>" />
                </td>
                <?php if (isset($params['errores']['direccion'])): ?>
                <td>Valor incorrecto</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>Población</th>
                <td>
                    <input type="text" name="poblacion" value="<?= $params["datos"]['poblacion'] ?>" />
                </td>
                <?php if (isset($params['errores']['poblacion'])): ?>
                <td>Valor incorrecto</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>Código Postal</th>
                <td>
                    <input type="text" name="cod_postal" value="<?= $params["datos"]['cod_postal'] ?>" />
                </td>
                <?php if (isset($params['errores']['cod_postal'])): ?>
                <td>Valor incorrecto</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>Provincia</th>
                <td>
                    <?=Helper::creaListaDesplegable("provincia", $params['provincias'], isset($params["datos"]['provincia'])? $params["datos"]['provincia'] : "0", ['nombre' => "--Seleccionar--", 'codigo' => "0"]) ?>
                </td>
                <?php if (isset($params['errores']['provincia'])): ?>
                <td>Valor incorrecto</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>Correo Electrónico</th>
                <td>
                    <input type="email" name="email" value="<?= $params["datos"]['email'] ?>" />
                </td>
                <?php if (isset($params['errores']['email'])): ?>
                <td>Valor incorrecto</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>Estado</th>
                <td>
                    <input type="text" name="estado" value="<?= $params["datos"]['estado'] ?>" readonly="readonly" />
                </td>
                <?php if (isset($params['errores']['estado'])): ?>
                <td>Valor incorrecto</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>Fecha de creación</th>
                <td>
                    <input type="date" name="fecha_creacion" value="<?= $params["datos"]['fecha_creacion'] ?>" readonly="readonly" />
                </td>
                <?php if (isset($params['errores']['fecha_creacion'])): ?>
                <td>Valor incorrecto</td>
                <?php endif; ?>
            </tr>
            <tr>
                <th>Observaciones</th>
                <td>
                    <textarea name="observaciones">
                        <?= $params["datos"]['observaciones'] ?>
                    </textarea>
                </td>
            </tr>
            <tr>
                <th>Zona de envío</th>
                <td>
                    <input type="text" value="<?= $params["datos"]['zona_envio'] ?>" name="zona_envio" readonly="readonly" />
                </td>
                <?php if (isset($params['errores']['zona_envio'])): ?>
                <td>Valor incorrecto</td>
                <?php endif; ?>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Insertar" />
                </td>
            </tr>
    </table>
</form>