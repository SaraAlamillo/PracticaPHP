<?php

/*
 * Clase encargada de gestionar las conexiones a la base de datos
 */

class DataBase {

    static $_instance;

    /* La funci�n construct es privada para evitar que el objeto pueda ser creado mediante new */

    private function __construct() {
        $this->Conectar(Config::$hostname, Config::$bd, Config::$usuario, Config::$clave);
    }

    /* Evitamos el clonaje del objeto. Patr�n Singleton */

    private function __clone() {
        
    }

    /*
     * Funci�n encargada de crear, si es necesario, el objeto. Esta es la funci�n que debemos llamar desde fuera de la clase para instanciar el objeto, y as�, poder utilizar sus m�todos
     */

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self ();
        }
        return self::$_instance;
    }

    /* Realiza la conexi�n a la base de datos. */

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
     * Ejecuta una consulta SQL y devuelve el resultado de esta
     *
     * @param string $sql        	
     *
     * @return mixed
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
     * Actualiza los datos de un registro
     *
     * @param string $tabla        	
     * @param integer $id        	
     * @param array $datos        	
     *
     * @return boolean
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
     * Inserta un nuevo registro en una tabla
     *
     * @param string $tabla        	
     * @param array $datos   
     * 
     * @return boolean	
     */
    public function Insertar($tabla, $datos) {
        $sql = "INSERT INTO $tabla "
                . "(" . implode(", ", array_keys($datos)) . ") "
                . "VALUES ('" . implode("', '", $datos) . "') ";

        $resultado = $this->link->query($sql);
        return $resultado;
    }

    /**
     * Borra un registro de una tabla
     *
     * @param string $tabla        	
     * @param integer $id    
     * 
     * @return boolean	    	
     */
    public function Borrar($tabla, $campo, $valorCampo) {
        $consulta = "delete from $tabla where $campo = '$valorCampo'";
  
        $resultado = $this->link->query($consulta);
        
        return $resultado;
    }

    public function existeElemento($tabla, $campos, $zonas) {

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

}
