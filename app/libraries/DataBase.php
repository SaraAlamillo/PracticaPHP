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
    public function Seleccionar($tabla, $campos, $condiciones, $limite, $orden) {
        $camposCondicion = [];

        if ($condiciones != NULL) {

            foreach ($condiciones as $condicion) {

                $condicion['valor'] = "'{$condicion['valor']}'";
                $camposCondicion[] = $condicion['campo'] . $condicion['conector'] . $condicion['valor'];
            }
            $camposCondicion = implode(" and ", $camposCondicion);
            $camposCondicion = " where " . $camposCondicion;
        } else {
            $camposCondicion = "";
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
    public function Actualizar($tabla, $id, $datos) {
        $campos = [];

        foreach ($datos as $clave => $valor) {

            $valor = "'$valor'";
            $campos[] = "$clave = $valor";
        }

        $campos = implode(",", $campos);
        $consulta = "update $tabla set $campos where codigo = $id";
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

        $this->link->query($sql);
    }

    /**
     * Borra un registro de una tabla
     *
     * @param string $tabla        	
     * @param integer $id    
     * 
     * @return boolean	    	
     */
    public function Borrar($tabla, $id) {
        $consulta = "delete from $tabla where codigo = $id";
        $resultado = $this->link->query($consulta);

        return $resultado;
    }

    public function existeElemento($tabla, $codigo) {
        $condiciones = [
            [
            "campo" => "codigo",
            "conector" => "=",
            "valor" => $codigo
                ]
        ];
        
        $resultado = $this->Seleccionar($tabla, "*", $condiciones, NULL, NULL);

        if (count($resultado) == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
