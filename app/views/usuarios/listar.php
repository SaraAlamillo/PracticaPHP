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
            <td class="noLink">
                <a href="index.php?action=modificarUsuario&usuario=<?= $usuario['codigo'] ?>" title="Modificar usuario">
                    <img src="<?= URL_IMAGES ?>iconos/modificar.png" />
                </a>
            </td>
            <td class="noLink">
                <a href="index.php?action=eliminarUsuario&usuario=<?= $usuario['codigo'] ?>" title="Eliminar usuario">
                    <img src="<?= URL_IMAGES ?>iconos/borrar.png" />
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<p>
    <button>
        <a href="index.php?action=<?= $params['action'] ?>&pagina=1"><<</a>
    </button>
    <button>
        <a href="index.php?action=<?= $params['action'] ?>&pagina=<?= $params['paginaActual'] - 1 ?>"><</a>
    </button>
    <input type="number" id="paginaBuscada" value="<?= $params['paginaActual'] ?>" onchange="cambiarPagina('<?= $params['action'] ?>')" min="1" max="<?= $params['numeroDePaginas'] ?>" /> de <?= $params['numeroDePaginas'] ?>
    <button>
        <a href="index.php?action=<?= $params['action'] ?>&pagina=<?= $params['paginaActual'] + 1 ?>">></a>
    </button>
    <button>
        <a href="index.php?action=<?= $params['action'] ?>&pagina=<?= $params['numeroDePaginas'] ?>">>></a>
    </button>
</p>