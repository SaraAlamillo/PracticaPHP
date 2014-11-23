<?php ob_start() ?>
<h3>No existen datos</h3>
<?php
$contenido = ob_get_clean();
include 'layout.php';
?>