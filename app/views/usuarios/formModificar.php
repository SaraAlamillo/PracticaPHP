<form action="index.php?action=<?=$params['action'] ?>&usuario=<?=$params['usuario'] ?>&confirmacion=<?=$params['confirmacion'] ?>" method="POST">
    <table>
            <tr>
                <th>
                    Nombre
                </th>
                <td>
                    <input type="text" name="nombre" value="<?= $params['antiguo']['nombre'] ?>" readonly="readonly" />
                </td>
            </tr>
            <tr>
                <th>
                    Contraseña
                </th>
                <td>
                    <input type="text" name="clave" value="<?= $params['antiguo']['clave'] ?>" />
                </td>
            </tr>
            <tr>
                <th>Rol</th>
                <td>
                    <input type="text" name="rol" value="<?= $params['antiguo']['rol'] ?>" />
                </td>
            </tr>
    </table>
    <input type="submit" value="<?=$params['action'] ?>" />
</form>