<form name="formEliminar" action="index.php" method="GET">
    ¿Está seguro que desea <?=$params['action'] ?> el envío <?=$params['id'] ?>?
    <input type="hidden" name="action" value="<?=$params['action'] ?>" />
    <input type="hidden" name="id" value="<?=$params['id'] ?>" />
    <input type="submit" name="confirmacion" value="Si" />
    <input type="submit" name="confirmacion" value="No" />
</form>
