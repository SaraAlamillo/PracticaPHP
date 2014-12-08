<?php if (isset($params['mensaje'])): ?>
    <p><?= $params['mensaje'] ?></p>
<?php endif; ?>

<form action="index.php?action=configParametros" method="POST">
    <table>
        <tr>
            <th colspan="2">Tiempo máximo de sesión</th>
            <td>
                <input type="text" name="tiempoSesion" value="<?= $params['antiguo']['tiempoSesion'] ?>" /> <br />
                <input type="radio" name="medida" value="horas" /> Horas 
                <input type="radio" name="medida" value="minutos" /> Minutos  
                <input type="radio" name="medida" value="segundos" checked="checked" /> Segundos
            </td>
        </tr>
        <tr>
            <th rowspan="2">Valores por defecto</th>
            <th>Provincia</th>
            <td>
                <?= Helper::creaListaDesplegable("provincia", $params['provincias'], $params['antiguo']['defecto']['provincia']) ?>
            </td>
        </tr>
        <tr>
            <th>Población</th>
            <td>
                <input type="text" name="poblacion" value="<?= $params['antiguo']['defecto']['poblacion'] ?>" />
            </td>
        </tr>
        <tr>
            <th colspan="2">Número máximo de elementos por página</th>
            <td>
                <input type="text" name="elemPag" value="<?= $params['antiguo']['elemPag'] ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <input type="submit" value="Configurar" />
            </td>
        </tr>
    </table>
</form>

