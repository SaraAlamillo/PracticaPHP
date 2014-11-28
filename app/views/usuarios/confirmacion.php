<form action="index.php" method="GET">
    ¿Está seguro que desea <?=$params['action'] ?> <?=$params['usuario'] ?>?
    <input type="hidden" name="action" value="<?=$params['action'] ?>" />
    <input type="hidden" name="usuario" value="<?=$params['usuario'] ?>" />
    <input type="submit" name="confirmacion" value="Si" />
    <input type="submit" name="confirmacion" value="No" />
</form>
