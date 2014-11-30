<form action="index.php" method="GET">
    ¿Está seguro que desea <?=$params['action'] ?> <?=$params['codigo'] ?>?
    <input type="hidden" name="action" value='<?=$params['action'] ?>' />
    <input type="hidden" name="codigo" value='<?=$params['codigo'] ?>' />
    <input type="submit" name="confirmacion" value="Si" />
    <input type="submit" name="confirmacion" value="No" />
</form>
