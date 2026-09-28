<?php

require_once __DIR__ . '/../config/load.php';

class conexion
{
    public $server;
    public $username;
    public $password;
    public $database;

    public function __construct()
    {
        // Los datos de conexión están en src/config/config.php (no se sube a GitHub)
        $db = flowmanager_config()['db'];
        $this->server = $db['host'];
        $this->username = $db['user'];
        $this->password = $db['password'];
        $this->database = $db['name'];
    }

    public function conectar()
    {
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Esto lanza excepciones
            $conexion = new mysqli($this->server, $this->username, $this->password, $this->database);
            $conexion->set_charset("utf8mb4");
            return $conexion;
        } catch (mysqli_sql_exception $e) {
            // Muestra un mensaje de error amigable
            $this->mostrarErrorBonito("No se pudo conectar a la base de datos. Por favor, intente más tarde.");
            exit;
        }
    }

    private function mostrarErrorBonito($mensaje)
    {
        echo <<<HTML
        <div style="margin: 50px auto; padding: 20px; max-width: 500px; border-radius: 10px; background-color: #ffe0e0; color: #900; font-family: Arial, sans-serif; box-shadow: 0 0 10px rgba(0,0,0,0.2); text-align: center;">
            <h2>Error de conexión</h2>
            <p>$mensaje</p>
        </div>
        HTML;
    }
}
