<form action="index.php?action=<?= $params['action'] ?>" method="POST">
    <table>
        <tr>
            <th>Código</th>
            <td><?= Helper::creaListaDesplegable("tipocodigo", $params['tipo_busqueda']['numero']) ?></td>
            <td>
                <input type="text" name="valorcodigo" />
                <input type="hidden" name="codigo" />
            </td>
        </tr>
        <tr>
            <th>Destinatario</th>
            <td><?= Helper::creaListaDesplegable("tipodestinatario", $params['tipo_busqueda']['palabra']) ?></td>
            <td>
                <input type="text" name="valordestinatario" />
                <input type="hidden" name="destinatario" />
            </td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td><?= Helper::creaListaDesplegable("tipotelefono", $params['tipo_busqueda']['palabra']) ?></td>
            <td>
                <input type="text" name="valortelefono" />
                <input type="hidden" name="telefono" />
            </td>
        </tr>
        <tr>
            <th>Dirección</th>
            <td><?= Helper::creaListaDesplegable("tipodireccion", $params['tipo_busqueda']['palabra']) ?></td>
            <td>
                <input type="text" name="valordireccion" />
                <input type="hidden" name="direccion" />
            </td>
        </tr>
        <tr>
            <th>Población</th>
            <td><?= Helper::creaListaDesplegable("tipopoblacion", $params['tipo_busqueda']['palabra']) ?></td>
            <td>
                <input type="text" name="valorpoblacion" />
                <input type="hidden" name="poblacion" />
            </td>
        </tr>
        <tr>
            <th>Código Postal</th>
            <td><?= Helper::creaListaDesplegable("tipocod_postal", $params['tipo_busqueda']['palabra']) ?></td>
            <td>
                <input type="text" name="valorcod_postal" />
                <input type="hidden" name="cod_postal" />
            </td>
        </tr>
        <tr>
            <th>Provincia</th>
            <td><?= Helper::creaListaDesplegable("tipoprovincia", $params['tipo_busqueda']['lista']) ?></td>
            <td>
                <?= creaListaDesplegable("valorprovincia", $params['provincias'], "0", [ 'nombre' => '--Seleccionar--', 'codigo' => "0"]) ?>
                <input type="hidden" name="provincia" />
            </td>
        </tr>
        <tr>
            <th>Correo Electrónico</th>
            <td><?= Helper::creaListaDesplegable("tipoemail", $params['tipo_busqueda']['palabra']) ?></td>
            <td>
                <input type="text" name="valoremail" />
                <input type="hidden" name="email" />
            </td>
        </tr>
        <tr>
            <th>Estado</th>
            <td><?= Helper::creaListaDesplegable("tipoestado", $params['tipo_busqueda']['lista']) ?></td>
            <td>
                <?= Helper::creaListaDesplegable("valorestado", $params['estados'], "0", [ 'nombre' => '--Seleccionar--', 'codigo' => "0"]) ?>
                <input type="hidden" name="estado" />
            </td>
        </tr>
        <tr>
            <th>Fecha de creación</th>
            <td><?= Helper::creaListaDesplegable("tipofecha_creacion", $params['tipo_busqueda']['numero']) ?></td>
            <td>
                <input type="date" name="valorfecha_creacion" />
                <input type="hidden" name="fecha_creacion" />
            </td>
        </tr>
        <tr>
            <th>Fecha de entrega</th>
            <td><?= Helper::creaListaDesplegable("tipofecha_entrega", $params['tipo_busqueda']['numero']) ?></td>
            <td>
                <input type="date" name="valorfecha_entrega" />
                <input type="hidden" name="fecha_entrega" />
            </td>
        </tr>
        <tr>
            <th>Observaciones</th>
            <td><?= Helper::creaListaDesplegable("tipoobservaciones", $params['tipo_busqueda']['palabra']) ?></td>
            <td>
                <textarea name="valorobservaciones"></textarea>
                <input type="hidden" name="observaciones" />
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <input type="submit" value="<?= $params['action'] ?>" />
            </td>
        </tr>
    </table>
</form>