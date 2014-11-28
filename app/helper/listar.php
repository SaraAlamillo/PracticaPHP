<?php

function paginar($accion, &$pagina, $modelo, $metodo, &$parametrosVista, $condiciones = NULL) {
    define("MaxPagina", "2");

    if (empty($pagina)) {
        $inicio = 0;
        $pagina = 1;
    } else {
        $inicio = ($pagina - 1) * MaxPagina;
    }

    $parametrosVista = [
        'datos' => $modelo->$metodo($condiciones, $inicio . "," . MaxPagina),
        'action' => $accion,
        'paginaActual' => $pagina,
        'numeroDePaginas' => ceil(count($modelo->$metodo($condiciones)) / MaxPagina),
        'controlesActivos' => [
            'primero' => '',
            'anterior' => '',
            'siguiente' => '',
            'ultimo' => ''
        ]
    ];

    if ($pagina == 1) {
        $parametrosVista['controlesActivos']['primero'] = "disabled='disabled'";
        $parametrosVista['controlesActivos']['anterior'] = "disabled='disabled'";
    }
    if ($pagina == $parametrosVista['numeroDePaginas']) {
        $parametrosVista['controlesActivos']['siguiente'] = "disabled='disabled'";
        $parametrosVista['controlesActivos']['ultimo'] = "disabled='disabled'";
    }
}
