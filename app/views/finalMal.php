<?php
ob_start();
?>
<p>Ups... Algo ha ido mal...</p>
<p><a href="index.php">Volver al inicio</a> | <a href="index.php?action=<?=$params['action'] ?>&id=<?=$params['id'] ?>">Volver a intentar</a></p>
<?php
$contenido = ob_get_clean();
include RUTA_VIEWS . 'layout.php';
?>