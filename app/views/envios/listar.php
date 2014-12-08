<?php if ($params['action'] == 'buscar'): ?>
    <button>
        <a href="index.php?action=<?= $params['action'] ?>&pagina=<?= $params['paginaActual'] ?>&nueva=true">Nueva búsqueda</a>
    </button>
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
        <th>Zona de envío</th>
        <th>Zona de recepción</th>
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
                <a href="index.php?action=modificar&id=<?= $envio['codigo'] ?>" title="Modificar envío">
                    <img src="<?= URL_IMAGES ?>iconos/modificar.png" />
                </a>
            </td>
            <td>
                <a href="index.php?action=eliminar&id=<?= $envio['codigo'] ?>" title="Eliminar envío">
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