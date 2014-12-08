<?php

/*
 * Clase encargada de gestionar las conexiones a la base de datos
 * 
 * @author Sara
 */

class DataBase {

    /**
     * Contiene la instancia de la base de datos
     * @var Object 
     */
    static $_instance;

    /**
     * Constructor de la clase DataBase
     * Es privado para evitar que se puedan crear objetos a través de new
     */
    private function __construct() {
        if (isset($_SESSION['parametros'])) {
            $this->Conectar($_SESSION['parametros']['servidor'], $_SESSION['parametros']['bd'], $_SESSION['parametros']['usuario'], $_SESSION['parametros']['clave']);
        } else {
            $this->Conectar(Config::$hostname, Config::$bd, Config::$usuario, Config::$clave);
        }
    }

    /**
     * Eliminación de la función clonar para seguir el patrón Singleton
     */
    private function __clone() {
        
    }

    /**
     * Comprueba si ya existe una instancia para la clase DataBase. Si no existe, la crea.
     * @return Object instancia de la clase DataBase
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self ();
        }
        return self::$_instance;
    }

    /**
     * Realiza la conexión con la base de datos
     * @param String $hostname Nombre del servidor
     * @param String $bd Nombre de la base de datos
     * @param String $usuario Nombre del usuario
     * @param String $clave Contraseña para el usuario
     */
    private function Conectar($hostname, $bd, $usuario, $clave) {
        $this->link = new mysqli($hostname, $usuario, $clave);

        /* check connection */
        if (!$this->link) {
            printf("Error de conexión: %s\n", mysqli_connect_error());
            exit();
        }

        $this->link->select_db($bd);
        $this->link->query("SET NAMES 'utf8'");
    }

    /**
     * Consulta datos a una tabla determinada de la base de datos
     * 
     * @param String $tabla Nombre de la tabla
     * @param String $campos Campos para la consulta
     * @param Array $condiciones Condiciones para los datos
     * @param String $limite Intervalo de registros que se mostrarán
     * @param String $orden Orden en el que se mostrarán
     * @param String $zonas Zonas en las que se va realizar la búsqueda
     * @return Array Devuelve todos los datos obtenidos en la consulta
     */
    public function Seleccionar($tabla, $campos, $condiciones, $limite, $orden, $zonas = NULL) {
        $camposCondicion = [];

        if ($condiciones != NULL) {

            foreach ($condiciones as $condicion) {
                if ($condicion['conector'] == 'like') {
                    $camposCondicion[] = $condicion['campo'] . " like concat('%', '" . $condicion['valor'] . "', '%')";
                } else {
                    $condicion['valor'] = "'{$condicion['valor']}'";
                    $camposCondicion[] = $condicion['campo'] . $condicion['conector'] . $condicion['valor'];
                }
            }
            $camposCondicion = implode(" and ", $camposCondicion);
            $camposCondicion = " where " . $camposCondicion;
        } else {
            $camposCondicion = "";
        }
        if ($zonas != NULL) {
            if ($condiciones == NULL) {
                $camposCondicion = " where " . $zonas;
            } else {
                $camposCondicion .= " and " . $zonas;
            }
        }

        if ($limite != NULL) {
            $limite = "limit " . $limite;
        } else {
            $limite = "";
        }

        if ($orden != NULL) {
            $orden = " order by " . $orden;
        } else {
            $orden = "";
        }

        $sql = "select $campos from $tabla $camposCondicion $orden $limite";

        $registros = $this->link->query($sql);

        $resultados = [];

        while ($registro = $registros->fetch_assoc()) {
            $resultados[] = $registro;
        }

        return $resultados;
    }

    /**
     * Actualiza los campos de una tabla determinada
     * @param String $tabla Nombre de la tabla
     * @param String $id Valor del identificador
     * @param String $campoID Nombre del campo identificador
     * @param Array $datos Campos que se actualizarán
     * @return Boolean Según el resultado de la consulta
     */
    public function Actualizar($tabla, $id, $campoID, $datos) {
        $campos = [];

        foreach ($datos as $clave => $valor) {

            $valor = "'$valor'";
            $campos[] = "$clave = $valor";
        }

        $campos = implode(",", $campos);
        $consulta = "update $tabla set $campos where $campoID = '$id'";

        $resultado = $this->link->query($consulta);

        return $resultado;
    }

    /**
     * Inserta una nueva fila en una tabla determinada de la base de datos
     * 
     * @param String $tabla Nombre de la tabla
     * @param Array $datos Campos que se insertarán
     * @return Boolean Según el resultado de la consulta
     */
    public function Insertar($tabla, $datos) {
        $sql = "INSERT INTO $tabla "
                . "(" . implode(", ", array_keys($datos)) . ") "
                . "VALUES ('" . implode("', '", $datos) . "') ";

        $resultado = $this->link->query($sql);
        return $resultado;
    }

    /**
     * Borra una fila de una tabla determinada en la base de datos
     * @param String $tabla Nombre de la tabla
     * @param String $campo Valor del identificador
     * @param String $valorCampo Nombre del campo identificador
     * @return Boolean Según el resultado de la consulta
     */
    public function Borrar($tabla, $campo, $valorCampo) {
        $consulta = "delete from $tabla where $campo = '$valorCampo'";

        $resultado = $this->link->query($consulta);

        return $resultado;
    }

    /**
     * Determinada si un elemento determinado está en una tabla determinada
     * @param String $tabla Nombre de la tabla
     * @param String $campos Datos del elemento buscado
     * @param String $zonas Zonas en las que se buscará el elemento
     * @return boolean Según si se ha encontrado o no el objeto
     */
    public function existeElemento($tabla, $campos, $zonas = NULL) {

        foreach ($campos as $key => $value) {
            $condiciones[] = [
                "campo" => $key,
                "conector" => "=",
                "valor" => $value
            ];
        }

        $resultado = $this->Seleccionar($tabla, "*", $condiciones, NULL, NULL, $zonas);

        if (count($resultado) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Comprueba si se puede establecer la conexión con el servidor y la base de datos
     * @param Array $parametros Datos para establecer la conexión
     * @param String $error En caso de que no se pueda establecer la conexión, recoge el fallo de dicha conexión
     * @return Boolean Según el resultado de la conexión
     */
    public static function pruebaConexion($parametros, &$error) {
        $conexion = @new mysqli($parametros['servidor'], $parametros['usuario'], $parametros['clave']);

        if ($conexion) {
            if (@$conexion->select_db($parametros['bd'])) {
                $error = NULL;
                return true;
            } else {
                $error = "No se puede conectar con la base de datos";
                return false;
            }
        } else {
            $error = "No se puede establecer la conexión con el servidor";
            return false;
        }
    }

    /**
     * Muestra todas las tablas de una base de datos
     * @param String $bd Nombre de la base de datos
     * @return Array Conjunto de los nombres de las tablas
     */
    public function mostrarTablas($bd) {
        $resultados = $this->link->query("show tables from $bd");

        $tablas = [];
        while ($row = $resultados->fetch_row()) {
            $tablas[] = $row[0];
        }
        return $tablas;
    }

    /**
     * Elimina todas las tablas de una base de datos
     * @param String $bd Nombre de la base de datos
     * @return Boolean Según el resultado de la consulta
     */
    public function eliminarTodasTablas($bd) {
        $sql = "SELECT CONCAT('drop table ',table_name,'; ') FROM information_schema.tables WHERE table_schema = '$bd'";

        $registros = $this->link->query($sql);
        while ($registro = $registros->fetch_row()) {
            echo $registro[0] . "<br />";
            if (!$this->link->query($registro[0])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Realiza una consulta determinada a la base de datos
     * @param String $sql Consulta que se ejecutará
     * @param String $error En caso de que exista un fallo, recogerá dicho fallo
     * @return boolean Según el resultado de la consulta
     */
    public function consulta($sql, &$error) {
        if ((!empty($sql)) || $sql != "") {
            $consulta = $this->link->query($sql);

            if (!$consulta) {
                $error = $this->link->error;
                return FALSE;
            }
        }
        $error = NULL;
        return TRUE;
    }

}
