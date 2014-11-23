<?php 
ob_start() ?>

<?php if (isset($params['mensaje'])) : ?>
    <b>
        <span style="color: red;"><?= $params['mensaje'] ?></span>
    </b>
<?php endif; ?>
<br/>
<form name="formInsertar" action="index.php?action=insertar" method="POST">
    <table>
        <label for="destinatario">
            <tr>
                <th>
                    Destinatario
                </th>
                <td>
                    <input type="text" name="destinatario" value="<?= $params["datos"]['destinatario'] ?>" />
                </td>
            </tr>
        </label>
        <label for="telefono">
            <tr>
                <th>Teléfono</th>
                <td>
                    <input type="text" name="telefono" value="<?= $params["datos"]['telefono'] ?>" />
                </td>
            </tr>
        </label>
        <label for="direccion">
            <tr>
                <th>Dirección</th>
                <td>
                    <input type="text" name="direccion" value="<?= $params["datos"]['direccion'] ?>" />
                </td>
            </tr>
        </label>
        <label for="poblacion">
            <tr>
                <th>Población</th>
                <td>
                    <input type="text" name="poblacion" value="<?= $params["datos"]['poblacion'] ?>" />
                </td>
            </tr>
        </label>
        <label for="cod_postal">
            <tr>
                <th>Código Postal</th>
                <td>
                    <input type="text" name="cod_postal" value="<?= $params["datos"]['cod_postal'] ?>" />
                </td>
            </tr>
        </label>
        <label for="provincia">
            <tr>
                <th>Provincia</th>
                <td>
                    <?=creaListaDesplegable("provincia", $params['provincias'], NULL) ?>
                </td>
            </tr>
        </label>
        <label for="email">
            <tr>
                <th>Correo Electrónico</th>
                <td>
                    <input type="text" name="email" value="<?= $params["datos"]['email'] ?>" />
                </td>
            </tr>
        </label>
        <label for="estado">
            <tr>
                <th>Estado</th>
                <td>
                    <input type="text" name="estado" value="<?= $params["datos"]['estado'] ?>" readonly="readonly" />
                </td>
            </tr>
        </label>
        <label for="fecha_creacion">
            <tr>
                <th>Fecha de creación</th>
                <td>
                    <input type="date" name="fecha_creacion" value="<?= $params["datos"]['fecha_creacion'] ?>" readonly="readonly" />
                </td>
            </tr>
        </label>
        <label for="observaciones">
            <tr>
                <th>Observaciones</th>
                <td>
                    <textarea name="observaciones">
                        <?= $params["datos"]['observaciones'] ?>
                    </textarea>
                </td>
            </tr>
        </label>
    </table>
    <input type="submit" value="Insertar" />
</form>

<?php
$contenido = ob_get_clean();
include 'layout.php';
?>