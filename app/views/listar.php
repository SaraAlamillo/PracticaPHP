<?php ob_start() ?>
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
    <button <?= $params['controlesActivos']['primero'] ?> onchange="cambiarPagina('<?= $params['action'] ?>')"><<</button>
    <button <?= $params['controlesActivos']['anterior'] ?> onchange="cambiarPagina('<?= $params['action'] ?>')"><</button>

    <input type="number" id="paginaBuscada" value="<?= $params['paginaActual'] ?>" onchange="cambiarPagina('<?= $params['action'] ?>')" min="1" max="<?= $params['numeroDePaginas'] ?>" /> de <?= $params['numeroDePaginas'] ?>

    <button <?= $params['controlesActivos']['siguiente'] ?> onchange="cambiarPagina('<?= $params['action'] ?>')">></button>
    <button <?= $params['controlesActivos']['ultimo'] ?> onchange="cambiarPagina('<?= $params['action'] ?>')">>></button>

</p>
<?php
$contenido = ob_get_clean();
include 'layout.php';
?>