<?php if (isset($params['mensaje'])): ?>
<p><?=$params['mensaje'] ?></p>
<?php endif; ?>
<p>Existen las siguientes tablas en la base de datos: </p>
<ul>
    <?php foreach ($params['tablas'] as $tabla): ?>
    <li><?=$tabla ?></li>
    <?php endforeach; ?>
</ul>
<p>Dichas tablas serán eliminadas. ¿Está seguro?</p>
<p>
<form action="index.php" method="GET">
    <input type="submit" value="Si" name="eliminar" />
    <input type="submit" value="No" name="eliminar" />
    <input type="hidden" value="paso3" name="action" />
</form>
</p>

