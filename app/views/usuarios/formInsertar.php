<form name="formInsertar" action="index.php?action=<?=$params['action'] ?>" method="POST">
    <table>
            <tr>
                <th>Nombre</th>
                <td>
                    <input type="text" name="nombre" value="<?= $params["datos"]['nombre'] ?>" />
                </td>
            </tr>
            <tr>
                <th>Contraseña</th>
                <td>
                    <input type="text" name="clave" value="<?= $params["datos"]['clave'] ?>" />
                </td>
            </tr>
            <tr>
                <th>Rol</th>
                <td>
                    <?=creaListaDesplegable("rol", $params['roles'], "Usuario") ?>
                </td>
            </tr>
    </table>
    <input type="submit" value="Insertar" />
</form>