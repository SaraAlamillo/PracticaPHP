<?php if ($params['error']): ?>
<p>Ups... algo ha fallado en los datos de prueba...</p>
<a href="index.php?action=paso5"><button>Volver a intentar</button></a>
<?php else: ?>
<p>Se han añadido los datos de prueba correctamente.</p>
<?php endif; ?>
<a href="index.php?action=paso6"><button>Continuar</button></a>