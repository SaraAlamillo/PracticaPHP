<form action="index.php?action=<?= $params['action'] ?>&usuario=<?= $params['usuario'] ?>&confirmacion=<?= $params['confirmacion'] ?>" method="POST">
    <table>
        <tr>
            <th>
                Código
            </th>
            <td>
                <input type="text" name="codigo" value="<?= $params['antiguo']['codigo'] ?>" readonly="readonly" />
            </td>
        </tr>
        <tr>
            <th>
                Nombre
            </th>
            <td>
                <input type="text" name="nombre" value="<?= $params['antiguo']['nombre'] ?>" />
            </td>
        </tr>
        <tr>
            <th>
                Contraseña
            </th>
            <td>
                <input type="password" name="clave" value="<?= $params['antiguo']['clave'] ?>" />
            </td>
        </tr>
        <tr>
            <th>Rol</th>
            <td>
                <input type="text" name="rol" value="<?= $params['antiguo']['rol'] ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="Modificar" />
            </td>
        </tr>
    </table>
</form>