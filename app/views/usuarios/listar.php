<table border="1">
    <tr>
        <th>Código</th>
        <th>Usuario</th>
        <th>Contraseña</th>
        <th>Rol</th>
    </tr>
    <?php
    foreach ($params['datos'] as $usuario):
        ?>
        <tr>
            <?php foreach ($usuario as $campo): ?>
                <td>
                    <?= $campo ?>
                </td>
                <?php
            endforeach;
            ?>
            <td>
                <a href="index.php?action=modificarUsuario&usuario=<?= $usuario['codigo'] ?>" title="Modificar usuario">Modificar</a>
            </td>
            <td>
                <a href="index.php?action=eliminarUsuario&usuario=<?= $usuario['codigo'] ?>" title="Eliminar usuario">Eliminar</a>
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