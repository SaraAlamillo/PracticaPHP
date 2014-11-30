<table border="1">
    <tr>
        <th>Código</th>
        <th>Nombre</th>
    </tr>
    <?php
    foreach ($params['datos'] as $zona):
        ?>
        <tr>
            <?php foreach ($zona as $campo): ?>
                <td>
                    <?= $campo ?>
                </td>
                <?php
            endforeach;
            ?>
            <td>
                <a href="index.php?action=modificarZona&codigo=<?= $zona['codigo'] ?>" title="Modificar zona">Modificar</a>
            </td>
            <td>
                <a href="index.php?action=eliminarZona&codigo=<?= $zona['codigo'] ?>" title="Eliminar zona">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

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