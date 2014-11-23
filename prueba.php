<?php
include "app/Config.php";
include "app/libraries/DataBase.php";
include "app/models/Model.php";

$model = new Model();

echo "<pre>";
print_r($model->obtenerTodasProvincias());
echo "</pre>";
