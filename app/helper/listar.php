<?php

function paginar($accion, &$pagina, $modelo, $metodo, &$parametrosVista, $condiciones = NULL) {
    define("MaxPagina", "2");
    $numTotalPaginas = ceil(count($modelo->$metodo($condiciones)) / MaxPagina);

    if (empty($pagina)) {
        $inicio = 0;
        $pagina = 1;
    } else if ($pagina < 1) {
        $pagina = 1;
        $inicio = ($pagina - 1) * MaxPagina;
    } elseif ($pagina > $numTotalPaginas) {
        $pagina = $numTotalPaginas;
        $inicio = ($pagina - 1) * MaxPagina;
    } else {
        $inicio = ($pagina - 1) * MaxPagina;
    }
  
    $parametrosVista = [
        'datos' => $modelo->$metodo($condiciones, $inicio . "," . MaxPagina),
        'action' => $accion,
        'paginaActual' => $pagina,
        'numeroDePaginas' => $numTotalPaginas,
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
