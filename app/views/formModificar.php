<?php 
ob_start() ?>
<form name="formModificar" action="index.php?action=<?=$params['action'] ?>&id=<?=$params['id'] ?>&confirmacion=<?=$params['confirmacion'] ?>" method="POST">
    <table>
        <label for="codigo">
            <tr>
                <th>
                    Código
                </th>
                <td>
                    <input type="text" name="codigo" value="<?= $params['antiguo']['codigo'] ?>" readonly="readonly" />
                </td>
            </tr>
        </label>
        <label for="destinatario">
            <tr>
                <th>
                    Destinatario
                </th>
                <td>
                    <input type="text" name="destinatario" value="<?= $params['antiguo']['destinatario'] ?>" />
                </td>
            </tr>
        </label>
        <label for="telefono">
            <tr>
                <th>Teléfono</th>
                <td>
                    <input type="text" name="telefono" value="<?= $params['antiguo']['telefono'] ?>" />
                </td>
            </tr>
        </label>
        <label for="direccion">
            <tr>
                <th>Dirección</th>
                <td>
                    <input type="text" name="direccion" value="<?= $params['antiguo']['direccion'] ?>" />
                </td>
            </tr>
        </label>
        <label for="poblacion">
            <tr>
                <th>Población</th>
                <td>
                    <input type="text" name="poblacion" value="<?= $params['antiguo']['poblacion'] ?>" />
                </td>
            </tr>
        </label>
        <label for="cod_postal">
            <tr>
                <th>Código Postal</th>
                <td>
                    <input type="text" name="cod_postal" value="<?= $params['antiguo']['cod_postal'] ?>" />
                </td>
            </tr>
        </label>
        <label for="provincia">
            <tr>
                <th>Provincia</th>
                <td>
                    <?=creaListaDesplegable("provincia", $params['provincias'], $params['antiguo']['provincia']) ?>
                </td>
            </tr>
        </label>
        <label for="email">
            <tr>
                <th>Correo Electrónico</th>
                <td>
                    <input type="text" name="email" value="<?= $params['antiguo']['email'] ?>" />
                </td>
            </tr>
        </label>
        <label for="estado">
            <tr>
                <th>Estado</th>
                <td>
                    <?=creaListaDesplegable("estado", $params['estados'], $params['antiguo']['estado']) ?>
                </td>
            </tr>
        </label>
        <label for="fecha_creacion">
            <tr>
                <th>Fecha de creación</th>
                <td>
                    <input type="date" name="fecha_creacion" value="<?= $params['antiguo']['fecha_creacion'] ?>" readonly="readonly" />
                </td>
            </tr>
        </label>
        <label for="fecha_entrega">
            <tr>
                <th>Fecha de entrega</th>
                <td>
                    <input type="date" name="fecha_entrega" value="<?= $params['antiguo']['fecha_entrega'] ?>" />
                </td>
            </tr>
        </label>
        <label for="observaciones">
            <tr>
                <th>Observaciones</th>
                <td>
                    <textarea name="observaciones"><?= $params['antiguo']['observaciones'] ?></textarea>
                </td>
            </tr>
        </label>
    </table>
    <input type="submit" value="<?=$params['action'] ?>" />
</form>

<?php
$contenido = ob_get_clean();
include 'layout.php';
?>