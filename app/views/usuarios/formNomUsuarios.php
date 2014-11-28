<p><?=  isset($params['error'])? $params['error'] : '' ?></p>
<form action="index.php" method="GET">
    Nombre del usuario: 
    <?=creaListaDesplegable(
            "usuario", 
            $params['usuarios'], 
            isset($params['usuario'])? $params['usuario'] : '0', 
            ['nombre' => '--Selecionar--', 'codigo' => '0']) 
    ?>
    <input type='hidden' name="action" value="<?=$params['action'] ?>" />
    <input type="submit" value="Continuar" />
</form>