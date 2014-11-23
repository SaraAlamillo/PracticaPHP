<?php
ob_start();
?>
<p>Se ha realizado la operación correctamente</p>
<p><a href="index.php">Volver al inicio</a> | <a href="index.php?action=<?=$params['action'] ?>">Volver al principio</a></p>
<?php
$contenido = ob_get_clean();
include RUTA_VIEWS . 'layout.php';
?>