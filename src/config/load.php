<?php
/**
 * Devuelve la configuración privada de src/config/config.php.
 * Ese archivo no se sube a GitHub: créalo copiando config.example.php.
 */
if (!function_exists('flowmanager_config')) {
    function flowmanager_config()
    {
        static $config = null;
        if ($config === null) {
            $file = __DIR__ . '/config.php';
            if (!is_file($file)) {
                http_response_code(500);
                exit('Falta src/config/config.php. Copia src/config/config.example.php como config.php y rellena tus datos.');
            }
            $config = require $file;
        }
        return $config;
    }
}
