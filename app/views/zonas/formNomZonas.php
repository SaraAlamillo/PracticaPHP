<p><?= isset($params['error']) ? $params['error'] : '' ?></p>
<form action="index.php" method="GET">
    Nombre de la zona: 
    <?=
    Helper::creaListaDesplegable(
            "codigo", $params['zonas'], isset($params['codigo']) ? $params['codigo'] : '0', ['nombre' => '--Selecionar--', 'codigo' => '0'])
    ?>
    <input type='hidden' name="action" value="<?= $params['action'] ?>" />
    <input type="submit" value="Continuar" />
</form>