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

    public function __construct() {
        $this->conexion = DataBase::getInstance();
        $this->modelEnvios = new ModelProvincias();
    }


    public function listarEnvios($condiciones, $limite = NULL) {
        $resultado = $this->conexion->Seleccionar($this->tabla, "*", $condiciones, $limite, "fecha_creacion desc");

        foreach ($resultado as &$registro) {
            foreach ($registro as $clave => &$valor) {
                if ($clave == 'estado') {
                    $valor = $this->obtenerEstadoCompleto($valor);
                } else if ($clave == 'provincia') {
                    $valor = $this->modelEnvios->obtenerUnaProvincia($valor);
                } else if ($clave == 'fecha_creacion') {
                    $valor = $this->mostrarFecha($valor);
                } else if ($clave == 'fecha_entrega') {
                    $valor = $this->mostrarFecha($valor);
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

        $resultado = $this->conexion->Seleccionar($this->tabla, "*", $condiciones, NULL, "fecha_creacion desc");

        foreach ($resultado as &$registro) {
            foreach ($registro as $clave => &$valor) {
                if ($clave == 'estado') {
                    $valor = $this->obtenerEstadoCompleto($valor);
                } else if ($clave == 'provincia') {
                    $valor = $this->modelEnvios->obtenerUnaProvincia($valor);
                } else if ($clave == 'fecha_creacion') {
                    $valor = $this->mostrarFecha($valor);
                } else if ($clave == 'fecha_entrega') {
                    $valor = $this->mostrarFecha($valor);
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
        $valores['estado'] = "P";
        $this->conexion->Insertar($this->tabla, $valores);
    }

    public function modificarEnvio($codigo, $datos) {
        return $this->conexion->Actualizar($this->tabla, $codigo, "codigo", $datos);
    }

    public function eliminarEnvio($id) {
        return $this->conexion->Borrar($this->tabla, "codigo", $id);
    }

    public function existeEnvio($codigo) {
        return $this->conexion->existeElemento($this->tabla, ["codigo" => $codigo]);
    }

    public function obtenerEstadoCompleto($letra) {
        $estados = $this->obtenerEstados();

        foreach ($estados as $estado) {
            if ($estado['codigo'] = $letra) {
                return $estado['nombre'];
            }
        }
    }

    public function obtenerEstadoLetra($estado) {
        $estados = $this->obtenerEstados();

        foreach ($estados as $clave => $valor) {
            if ($valor == $estado) {
                return $clave;
            }
        }
    }

    public function obtenerEstados() {
        return [
            [
                "codigo" => "P",
                "nombre" => "Pendiente"
            ],
            [
                "codigo" => "D",
                "nombre" => "Devuelto"
            ],
            [
                "codigo" => "E",
                "nombre" => "Entregado"
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
