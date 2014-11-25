<?php if ($params['action'] == 'buscar'): ?>
<a href="index.php?action=<?=$params['action'] ?>&pagina=<?=$params['paginaActual'] ?>&nueva=true">
    <p>Nueva búsqueda</p>
</a>
<?php endif; ?>
<table border="1">
    <tr>
        <th>Código</th>
        <th>Destinatario</th>
        <th>Teléfono</th>
        <th>Dirección</th>
        <th>Población</th>
        <th>Código Postal</th>
        <th>Provincia</th>
        <th>Correo electrónico</th>
        <th>Estado</th>
        <th>Fecha de creación</th>
        <th>Fecha de entrega</th>
        <th>Observaciones</th>
    </tr>
    <?php
    foreach ($params['datos'] as $envio):
        ?>
        <tr>
            <?php foreach ($envio as $clave => $campo): ?>
                <td>
                    <?= $campo ?>
                </td>
                <?php
            endforeach;
            ?>
            <td>
                <a href="index.php?action=modificar&id=<?= $envio['codigo'] ?>" title="Modificar envío">Modificar</a>
            </td>
            <td>
                <a href="index.php?action=eliminar&id=<?= $envio['codigo'] ?>" title="Eliminar envío">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<script src="<?= URL_JS ?>paginacion.js"></script>
<p>
    <a href="index.php?action=<?= $params['action'] ?>&pagina=1">
        <button <?= $params['controlesActivos']['primero'] ?>><<</button>
    </a>
    <a href="index.php?action=<?= $params['action'] ?>&pagina=<?= $params['paginaActual'] - 1 ?>">
        <button <?= $params['controlesActivos']['anterior'] ?>><</button>
    </a>

    <input type="number" id="paginaBuscada" value="<?= $params['paginaActual'] ?>" onchange="cambiarPagina('<?= $params['action'] ?>')" min="1" max="<?= $params['numeroDePaginas'] ?>" /> de <?= $params['numeroDePaginas'] ?>

    <a href="index.php?action=<?= $params['action'] ?>&pagina=<?= $params['paginaActual'] + 1 ?>">
        <button <?= $params['controlesActivos']['siguiente'] ?>>></button>
    </a>
    <a href="index.php?action=<?= $params['action'] ?>&pagina=<?= $params['numeroDePaginas'] ?>">
        <button <?= $params['controlesActivos']['ultimo'] ?>>>></button>
    </a>

</p>