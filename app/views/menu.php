<section id="menu">
    <fieldset id="fEnvios">
        <legend>Envíos</legend>
        <a href="index.php?action=listar">listar</a> |
        <a href="index.php?action=insertar">insertar</a> |
        <a href="index.php?action=buscar">buscar</a> |
        <a href="index.php?action=eliminar">eliminar</a> |
        <a href="index.php?action=recepcionar">anotar recepción</a> |
        <a href="index.php?action=modificar">modificar datos</a>
    </fieldset>
    <?php if (isset($_SESSION['admin'])): ?>
    <fieldset id="fUsuarios">
            <legend>Usuarios</legend>
            <a href="index.php?action=listarUsuarios">listar</a> |
            <a href="index.php?action=insertarUsuario">insertar</a> |
            <a href="index.php?action=eliminarUsuario">eliminar</a> |
            <a href="index.php?action=modificarUsuario">modificar datos</a>
        </fieldset>
        <fieldset id="fZonas">
            <legend>Zonas</legend>
            <a href="index.php?action=listarZonas">listar</a> |
            <a href="index.php?action=insertarZona">insertar</a> |
            <a href="index.php?action=eliminarZona">eliminar</a> |
            <a href="index.php?action=modificarZona">modificar datos</a>
        </fieldset>
    <?php endif; ?>
    
</section>
