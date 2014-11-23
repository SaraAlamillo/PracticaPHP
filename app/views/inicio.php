<?php ob_start() ?>
<h1>Inicio</h1>
<?= $params['mensaje'] ?>

<?php
$contenido = ob_get_clean();
include 'layout.php';
?>