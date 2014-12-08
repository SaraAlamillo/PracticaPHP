<?php if ($params['error']): ?>
    <p>Ups... algo ha fallado en los datos de prueba...</p>
    <button>
        <a href="index.php?action=paso5">Volver a intentar</a>
    </button>
    <?php else: ?>
    <p>Se han añadido los datos de prueba correctamente.</p>
    <?php endif; ?>
<button>
    <a href="index.php?action=paso6">Continuar</a>
</button>