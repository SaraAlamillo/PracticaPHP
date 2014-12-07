<?php

/**
 * Contiene las diferentes funciones que emulan los modelos
 *
 * @author Sara
 */
class ModelEnvios {

    private $conexion;
    private $modelEnvios;
    private $tabla = "envios";
    private $modelZonas;

    public function __construct() {
        $this->conexion = DataBase::getInstance();
        $this->modelEnvios = new ModelProvincias();
        $this->modelZonas = new ModelZonas();
    }

    public function listarEnvios($condiciones, $limite = NULL) {
        $zonas = "(zona_envio='{$_SESSION['zona']}' or zona_recepcion='{$_SESSION['zona']}')";
        $resultado = $this->conexion->Seleccionar($this->tabla, "*", $condiciones, $limite, "fecha_creacion desc", $zonas);

        foreach ($resultado as &$registro) {
            foreach ($registro as $clave => &$valor) {
                if ($clave == 'provincia') {
                    $valor = $this->modelEnvios->obtenerUnaProvincia($valor);
                } else if ($clave == 'fecha_creacion') {
                    $valor = $this->mostrarFecha($valor);
                } else if ($clave == 'fecha_entrega') {
                    $valor = $this->mostrarFecha($valor);
                } else if ($clave == 'zona_envio' || $clave == 'zona_recepcion') {
                    $valor = $this->modelZonas->obtenerNombre($valor);
                }
            }
        }

        if (count($resultado) != 0) {
            return $resultado;
        } else {
            return NULL;
        }
    }

    public function listarUnEnvio($codigo) {
        $condiciones = [
            [
                "campo" => "codigo",
                "conector" => "=",
                "valor" => $codigo
            ]
        ];

        $zonas = "(zona_envio='{$_SESSION['zona']}' or zona_recepcion='{$_SESSION['zona']}')";

        $resultado = $this->conexion->Seleccionar($this->tabla, "*", $condiciones, NULL, "fecha_creacion desc", $zonas);

        foreach ($resultado as &$registro) {
            foreach ($registro as $clave => &$valor) {
                if ($clave == 'provincia') {
                    $valor = $this->modelEnvios->obtenerUnaProvincia($valor);
                } elseif ($clave == 'zona_envio') {
                    $valor = $this->modelZonas->obtenerNombre($valor);
                } elseif ($clave == 'zona_recepcion' && !is_null($valor)) {
                    $valor = $this->modelZonas->obtenerNombre($valor);
                }
            }
        }
        if (count($resultado) != 0) {
            return $resultado[0];
        } else {
            return NULL;
        }
    }

    public function insertarEnvio($valores) {
        return $this->conexion->Insertar($this->tabla, $valores);
    }

    public function modificarEnvio($codigo, $datos) {
        return $this->conexion->Actualizar($this->tabla, $codigo, "codigo", $datos);
    }

    public function eliminarEnvio($id) {
        return $this->conexion->Borrar($this->tabla, "codigo", $id);
    }

    public function existeEnvio($codigo, $recepcionar = FALSE) {
        if ($recepcionar) {
            $zonas = NULL;
        } else {
            $zonas = "(zona_envio='{$_SESSION['zona']}' or zona_recepcion='{$_SESSION['zona']}')";
        }
        return $this->conexion->existeElemento($this->tabla, ["codigo" => $codigo], $zonas);
    }

    public function elementoRecepcionado($codigo) {
        $condiciones = [
            [
                "campo" => "codigo",
                "conector" => "=",
                "valor" => $codigo
            ]
        ];
        $resultado = $this->conexion->Seleccionar($this->tabla, "fecha_entrega", $condiciones, NULL, NULL, NULL);

        if ($resultado[0]['fecha_entrega'] == "") {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function obtenerEstados() {
        return [
            [
                "nombre" => "Pendiente",
                "codigo" => "Pendiente"
            ],
            [
                "nombre" => "Devuelto",
                "codigo" => "Devuelto"
            ],
            [
                "nombre" => "Entregado",
                "codigo" => "Entregado"
            ]
        ];
    }

    public function mostrarFecha($fecha) {
        if ($fecha == NULL || $fecha == "0000-00-00") {
            return "";
        } else {
            return date_format(date_create($fecha), "d-m-Y");
        }
    }

    public function obtenerTiposBusqueda() {
        return [
            "palabra" => [
                [
                    "codigo" => "=",
                    "nombre" => "Igual que"
                ],
                [
                    "codigo" => "!=",
                    "nombre" => "Distinto de"
                ],
                [
                    "codigo" => "like",
                    "nombre" => "Que contenga"
                ]
            ],
            "numero" => [
                [
                    "codigo" => "=",
                    "nombre" => "Igual que"
                ],
                [
                    "codigo" => "!=",
                    "nombre" => "Distinto de"
                ],
                [
                    "codigo" => "&gt;",
                    "nombre" => "Mayor que"
                ],
                [
                    "codigo" => "&gt;=",
                    "nombre" => "Mayor o igual que"
                ],
                [
                    "codigo" => "&lt;",
                    "nombre" => "Menor que"
                ],
                [
                    "codigo" => "&lt;=",
                    "nombre" => "Menor o igual que"
                ]
            ],
            "lista" => [
                [
                    "codigo" => "=",
                    "nombre" => "Igual que"
                ],
                [
                    "codigo" => "!=",
                    "nombre" => "Distinto de"
                ]
            ]
        ];
    }

    public function obtenerCamposFormulario() {
        return [
            'codigo',
            'destinatario',
            'telefono',
            'direccion',
            'poblacion',
            'cod_postal',
            'provincia',
            'email',
            'estado',
            'fecha_creacion',
            'fecha_entrega',
            'observaciones'
        ];
    }

}
