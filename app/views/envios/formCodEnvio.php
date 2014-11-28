<p><?=  isset($params['error'])? $params['error'] : '' ?></p>
<form name="formEliminar" action="index.php?action=<?=$params['action'] ?>" method="GET">
    Código del envío: <input type="text" name="id" value="<?=  isset($params['id'])? $params['id'] : '' ?>" />
    <input type="hidden" name="action" value="<?=$params['action'] ?>" />
    <input type="submit" value="Continuar" />
</form>