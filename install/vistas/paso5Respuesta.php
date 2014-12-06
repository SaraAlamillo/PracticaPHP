<?php if ($params['error']): ?>
<p>Ups... algo ha fallado en los datos de prueba...</p>
<a href="index.php?action=paso6"><button>Volver a intentar</button></a>
<?php else: ?>
<p>Se han añadido los datos de prueba correctamente. Para poder acceder a la aplicación dispone del usuario "admin" con contraseña "admin".</p>
<?php endif; ?>
<a href="<?=RUTA_APP ?>index.php"><button>Finalizar</button></a>