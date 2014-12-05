<div id="cabecera">
    <?php if (! $instalador && isset($validado)): ?>
        <p>
            <?= $hora ?>
        </p>
        <p><a href="index.php?action=salir">Salir</a></p>
        <p>
        <form action="index.php?action=cambiarZona" method="POST">
        <?=creaListaDesplegable(
                "nuevaZona", 
                $listadoZonas, 
                $zona, 
                NULL, 
                ['desc' => 'nombre', 'valor' => 'codigo'], 
                "onchange='cambiarZona()'") 
            ?>
            <input type="submit" value="Cambiar" />
            </form>
        </p>
    <?php endif; ?>
    <h1>Administración de los Envíos</h1>
</div>

