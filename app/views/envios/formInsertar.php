<form action="index.php?action=insertar" method="POST">
    <table>
            <tr>
                <th>
                    Destinatario
                </th>
                <td>
                    <input type="text" name="destinatario" value="<?= $params["datos"]['destinatario'] ?>" />
                </td>
            </tr>
            <tr>
                <th>Teléfono</th>
                <td>
                    <input type="tel" name="telefono" value="<?= $params["datos"]['telefono'] ?>" />
                </td>
            </tr>
            <tr>
                <th>Dirección</th>
                <td>
                    <input type="text" name="direccion" value="<?= $params["datos"]['direccion'] ?>" />
                </td>
            </tr>
            <tr>
                <th>Población</th>
                <td>
                    <input type="text" name="poblacion" value="<?= $params["datos"]['poblacion'] ?>" />
                </td>
            </tr>
            <tr>
                <th>Código Postal</th>
                <td>
                    <input type="text" name="cod_postal" value="<?= $params["datos"]['cod_postal'] ?>" />
                </td>
            </tr>
            <tr>
                <th>Provincia</th>
                <td>
                    <?=creaListaDesplegable("provincia", $params['provincias'], "0", ['nombre' => "--Seleccionar--", 'codigo' => "0"]) ?>
                </td>
            </tr>
            <tr>
                <th>Correo Electrónico</th>
                <td>
                    <input type="email" name="email" value="<?= $params["datos"]['email'] ?>" />
                </td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>
                    <input type="text" name="estado" value="<?= $params["datos"]['estado'] ?>" readonly="readonly" />
                </td>
            </tr>
            <tr>
                <th>Fecha de creación</th>
                <td>
                    <input type="date" name="fecha_creacion" value="<?= $params["datos"]['fecha_creacion'] ?>" readonly="readonly" />
                </td>
            </tr>
            <tr>
                <th>Observaciones</th>
                <td>
                    <textarea name="observaciones">
                        <?= $params["datos"]['observaciones'] ?>
                    </textarea>
                </td>
            </tr>
    </table>
    <input type="submit" value="Insertar" />
</form>