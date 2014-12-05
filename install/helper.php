<?php

function importSql($fichero) {
    // Reading SQL from file
    echo "Leyendo SQL desde el archivo '" . $fichero . "': ";
        $lines = file($fichero);
    echo " HECHO!<br />";

    echo "Importando SQL dentro de la base de datos '" . $_SESSION['parametros']['servidor'] . "': ";
    
    foreach ($lines as $key => $line) {
        if (substr($line, 0, 2) == "--") {
            unset($lines[$key]);
        }
    }
    $lines = array_values($lines);
    
    $lines = implode(" ", $lines);
    $lines = explode(";", $lines);
    $x = 0;
    $procent = 0;
    foreach ($lines as $line) {
    
        if (! DataBase::consulta($line, $_SESSION['parametros'])) {
            echo "<br />" . $line . "<br />";
        return false;    
        }
        
    }
    echo " HECHO!<br />";
    return true;
    
}
