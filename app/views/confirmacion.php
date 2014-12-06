<form action="index.php" method="GET">
    ¿Está seguro que desea <?=$params['action'] ?> el envío <?=$params['id'] ?>?
    <input type="hidden" name="action" value='<?=$params['action'] ?>' />
    <input type="hidden" name="<?=$params['nomCampoID'] ?>" value='<?=$params[$params['nomCampoID']] ?>' />
    <input type="submit" name="confirmacion" value="Si" />
    <input type="submit" name="confirmacion" value="No" />
</form>
