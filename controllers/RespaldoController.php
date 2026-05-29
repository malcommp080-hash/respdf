<?php

class RespaldoController {
    public function index() {
        $mensaje = '';
        $error   = '';
        require_once 'views/Respaldo/index.php';
    }

    public function descargar() {
        $db     = Database::getConnection();
        $fecha  = date('Y-m-d_H-i-s');
        $nombre = "respaldo_$fecha.sql";

        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=$nombre");
        header('Content-Transfer-Encoding: binary');

        echo "-- Respaldo de base de datos: " . DB_NAME . "\n";
        echo "-- Fecha: " . date('Y-m-d H:i:s') . "\n\n";
        echo "SET FOREIGN_KEY_CHECKS=0;\n\n";

        $tablas = $db->query('SHOW TABLES');
        while ($tabla = $tablas->fetch_array()) {
            $t = $tabla[0];
            echo "DROP TABLE IF EXISTS `$t`;\n";
            $create = $db->query("SHOW CREATE TABLE `$t`")->fetch_array();
            echo $create[1] . ";\n\n";

            $datos = $db->query("SELECT * FROM `$t`");
            while ($fila = $datos->fetch_row()) {
                $vals = array_map(function($v) use ($db) {
                    return $v === null ? 'NULL' : "'" . $db->real_escape_string($v) . "'";
                }, $fila);
                echo "INSERT INTO `$t` VALUES (" . implode(', ', $vals) . ");\n";
            }
            echo "\n";
        }

        echo "SET FOREIGN_KEY_CHECKS=1;\n";
        exit;
    }

    public function restaurar() {
        $mensaje = '';
        $error   = '';

        if (isset($_FILES['archivo_sql'])) {
            $archivo   = $_FILES['archivo_sql'];
            $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);

            if ($extension !== 'sql') {
                $error = 'Solo se permiten archivos .sql';
            } elseif ($archivo['error'] !== 0) {
                $error = 'Error al subir el archivo.';
            } else {
                $db      = Database::getConnection();
                $sql     = file_get_contents($archivo['tmp_name']);
                $queries = explode(';', $sql);
                $ok = $fail = 0;
                foreach ($queries as $q) {
                    $q = trim($q);
                    if ($q !== '') {
                        $db->query($q) ? $ok++ : $fail++;
                    }
                }
                $mensaje = "Restauración completada — $ok consultas exitosas, $fail fallidas.";
            }
        }

        require_once 'views/Respaldo/index.php';
    }
}
