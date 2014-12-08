<p><?= isset($params['error']) ? $params['error'] : '' ?></p>
<form action="index.php" method="GET">
    Código del envío: <input type="text" name="id" value="<?= isset($params['id']) ? $params['id'] : '' ?>" />
    <input type="hidden" name="action" value="<?= $params['action'] ?>" />
    <input type="submit" value="Continuar" />
</form>