<?php

/**
 * Description of ControllerInstaller
 *
 * @author Sara
 */
class ControllerInstaller {

    private $modelo;

    public function __construct() {
    }

    public function paso1() {
        if (isset($_POST['siguiente'])) {
            header("Location: index.php?action=paso2");
        } else {
            require "vistas/paso1.php";
        }
    }

    public function paso2() {
        $params = [
            "datos" => [
                'servidor' => '',
                'bd' => '',
                'usuario' => '',
                'clave' => ''
            ]
        ];
        if ($_POST) {
            if (DataBase::pruebaConexion($_POST, $params['mensaje'])) {
                $_SESSION['parametros'] = $_POST;
                $this->modelo = new ModelInstaller($_POST);
                header("Location: index.php?action=paso3");
            } else {
                $params['datos'] = $_POST;
            }
        }
        require "vistas/paso2.php";
    }

    public function paso3() {
        $params['tablas'] = $this->modelo->tablasExistentes();
        if ($params['tablas'] == NULL) {
            if ($_POST) {
                header("Location: index.php?action=paso4");
            }
            require 'vistas/paso3SinTablas.php';
        } else {
            if ($_GET) {
                if (isset($_GET['eliminar']) && $_GET['eliminar'] == 'Si') {
                    if (DataBase::eliminarTablas($_SESSION['parametros'])) {
                        header("Location: index.php?action=paso4");
                    } else {
                        $params['mensaje'] = "Ups... no se han podido borrar las tablas...";
                    }
                } else if (isset($_GET['eliminar']) && $_GET['eliminar'] == 'No') {
                    header("Location: index.php?action=paso2");
                }
            }

            require 'vistas/paso3ConTablas.php';
        }
    }

    public function paso4() {
        if (importSql("base_datos.sql")) {
            $params['mensaje'] = "Se han creado las tablas correctamente.";
            $params['siguienteAction'] = "paso5";
        } else {
            $params['mensaje'] = "Ha fallado algo en la creación de las tablas. Pulse para volver a intentarlo.";
            $params['siguienteAction'] = "paso3&eliminar=Si";
        }
        require 'vistas/paso4.php';
    }

    public function paso5() {
        $fichero = fopen("../app/Config.php", "w");
        fwrite($fichero, "<?php\n");
        fwrite($fichero, "\n");
        fwrite($fichero, "/**\n");
        fwrite($fichero, "* Contiene la configuración de la aplicación\n");
        fwrite($fichero, "*\n");
        fwrite($fichero, "* @author Sara\n");
        fwrite($fichero, "*/\n");
        fwrite($fichero, "class Config {\n");
        fwrite($fichero, "\n");
        fwrite($fichero, "/**\n");
        fwrite($fichero, " * Nombre del servidor\n");
        fwrite($fichero, "*/\n");
        fwrite($fichero, "static public \$hostname = \"{$_SESSION['parametros']['servidor']}\";\n");
        fwrite($fichero, "\n");
        fwrite($fichero, "/**\n");
        fwrite($fichero, " * Nombre de la base de datos\n");
        fwrite($fichero, " */\n");
        fwrite($fichero, "static public \$bd = \"{$_SESSION['parametros']['bd']}\";\n");
        fwrite($fichero, "\n");
        fwrite($fichero, "/**\n");
        fwrite($fichero, " * Nombre del usuario para la conexión\n");
        fwrite($fichero, " */\n");
        fwrite($fichero, "static public \$usuario = \"{$_SESSION['parametros']['usuario']}\";\n");
        fwrite($fichero, "\n");
        fwrite($fichero, "/**\n");
        fwrite($fichero, " * Contraseña del usuario para la conexión\n");
        fwrite($fichero, " */\n");
        fwrite($fichero, "static public \$clave = \"{$_SESSION['parametros']['clave']}\";\n");
        fwrite($fichero, " \n");
        fwrite($fichero, "}");
        fclose($fichero);
        
        require 'vistas/paso5.php';
    }

}
