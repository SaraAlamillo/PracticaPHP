<form action="index.php" method="GET">
    ¿Está seguro que desea <?= $params['accion'] ?> <?= $params[$params['nomCampoID']] ?>?
    <input type="hidden" name="action" value='<?= $params['action'] ?>' />
    <input type="hidden" name="<?= $params['nomCampoID'] ?>" value='<?= $params[$params['nomCampoID']] ?>' />
    <input type="submit" name="confirmacion" value="Si" />
    <input type="submit" name="confirmacion" value="No" />
</form>
