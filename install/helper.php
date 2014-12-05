<?php

function importSql($fichero, $modelo) {
    $lines = file($fichero);
    foreach ($lines as $key => $line) {
        if (substr($line, 0, 2) == "--") {
            unset($lines[$key]);
        }
    }
    $lines = array_values($lines);

    $lines = implode(" ", $lines);
    $lines = explode(";", $lines);
    
    foreach ($lines as $line) {
        $modelo->hacerConsulta($line, $error);
        if (! is_null($error)) {
            echo $error . "<br />";
            return false;
        }
    }
    return true;
}
