<div id="cabecera">
    <?php if (! $instalador && isset($validado)): ?>
    <div id="datosUsuario">  
        <div id="usuario">
    Hola, <?=$usuario ?>. Has accedido a esta hora: <?= $hora ?>
    <br />
    <form action="index.php?action=cambiarZona" method="POST">
        <?=Helper::creaListaDesplegable(
                "nuevaZona", 
                $listadoZonas, 
                $zona, 
                NULL, 
                ['desc' => 'nombre', 'valor' => 'codigo'], 
                "onchange='cambiarZona()'") 
            ?>
            <input type="submit" value="Cambiar" />
            </form>
        </div>
        <div class="salir noLink">
            <a href="index.php?action=salir"><img src="<?=URL_IMAGES . "iconos/salir.png" ?>" /></a>
        </div>
            </div>  
    <?php endif; ?>
    <h1><a href="index.php?action=inicio">Administración de los Envíos</a></h1>
</div>

