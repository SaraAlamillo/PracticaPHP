<form action="index.php?action=<?= $params['action'] ?>&codigo=<?= $params['codigo'] ?>&confirmacion=<?= $params['confirmacion'] ?>" method="POST">
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
            <td colspan="2">
                <input type="submit" value="Modificar" />
            </td>
        </tr>
    </table>
</form>