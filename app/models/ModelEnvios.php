<?php

/**
 * Contiene las diferentes funciones que emulan los modelos para los controladores
 *
 * @author Sara
 */
class ModelEnvios {

    /**
     * Enlace con la capa de abstacción de base de datos
     * @var Object 
     */
    private $conexion;

    /**
     * Enlace con el modelo de provincias
     * @var Object 
     */
    private $modelProvincias;

    /**
     * Nombre de la tabla sobre la que trabajará el modelo
     * @var String 
     */
    private $tabla = "envios";

    /**
     * Enlace con el modelo de zonas
     * @var Object
     */
    private $modelZonas;

    /**
     * Contructor de la clase ModelEnvios
     */
    public function __construct() {
        $this->conexion = DataBase::getInstance();
        $this->modelProvincias = new ModelProvincias();
        $this->modelZonas = new ModelZonas();
    }

    /**
     * Devulve todos los envíos de la zona actual
     * @param Array $condiciones Criterios para el listado
     * @param String $limite Intervalo de registros que mostrará
     * @return Array Datos para el listado
     */
    public function listarEnvios($condiciones, $limite = NULL) {
        $zonas = "(zona_envio='{$_SESSION['zona']}' or zona_recepcion='{$_SESSION['zona']}')";
        $resultado = $this->conexion->Seleccionar($this->tabla, "*", $condiciones, $limite, "fecha_creacion desc", $zonas);

        foreach ($resultado as &$registro) {
            foreach ($registro as $clave => &$valor) {
                if ($clave == 'provincia') {
                    $valor = $this->modelProvincias->obtenerUnaProvincia($valor);
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

    /**
     * Devuelve la consulta de un envío concreto
     * @param String $codigo Identificador del envío
     * @return Array Datos del envío
     */
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
                    $valor = $this->modelProvincias->obtenerUnaProvincia($valor);
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

    /**
     * Añade un nuevo envío
     * @param Array $valores Datos del nuevo envío
     * @return Boolean Según el resultado de la consulta
     */
    public function insertarEnvio($valores) {
        return $this->conexion->Insertar($this->tabla, $valores);
    }

    /**
     * Actualiza los datos de un envío determinado
     * @param String $codigo Identificador del envío
     * @param Array $datos Datos nuevos para el envío
     * @return Boolean Según el resultado de la consulta
     */
    public function modificarEnvio($codigo, $datos) {
        return $this->conexion->Actualizar($this->tabla, $codigo, "codigo", $datos);
    }

    /**
     * Elimina un envío determinado de la tabla
     * @param String $id Identificador del envío
     * @return Boolean Según el resultado de la consulta
     */
    public function eliminarEnvio($id) {
        return $this->conexion->Borrar($this->tabla, "codigo", $id);
    }

    /**
     * Comprueba si existe un envío en la base de datos
     * @param String $codigo Identificador del envío
     * @param Boolean $recepcionar Si la consulta es para recepcionar un envío, no se comprueba por zonas
     * @return Boolean Según la existencia del envío
     */
    public function existeEnvio($codigo, $recepcionar = FALSE) {
        if ($recepcionar) {
            $zonas = NULL;
        } else {
            $zonas = "(zona_envio='{$_SESSION['zona']}' or zona_recepcion='{$_SESSION['zona']}')";
        }
        return $this->conexion->existeElemento($this->tabla, ["codigo" => $codigo], $zonas);
    }

    /**
     * Comprueba si un envío ya ha sido recepcionado
     * @param String $codigo Identificador del envío
     * @return Boolean Según la recepción del envío
     */
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

    /**
     * Devuelve un array con los diversos estados en los que puede estar un envío
     * @return Array
     */
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

    /**
     * Devuelve una fecha formateada en Día-Mes-Año
     * @param Date $fecha Fecha para mostrar
     * @return String Fecha formateada
     */
    public function mostrarFecha($fecha) {
        if ($fecha == NULL || $fecha == "0000-00-00") {
            return "";
        } else {
            return date_format(date_create($fecha), "d-m-Y");
        }
    }

    /**
     * Devuelve los diversos tipos de búsqueda que existen
     * @return Array
     */
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

    /**
     * Devuelve los diversos campos que pueden existir en un formulario
     * @return Array
     */
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
