<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once "../../database/conexion.php";
require_once "../../includes/classes/selectAll.php";

try {
    // Crear instancia de la clase selectAllClass
    $selectAll = new selectAllClass();

    // Obtener la cantidad de proyectos por estado
    $tabla = "proyectos"; // Cambia esto por el nombre de tu tabla
    $estadoColumn = "estado_proyecto"; // Cambia esto por el nombre de la columna de estado
    $datos = $selectAll->selectProjectStatusCount($tabla, $estadoColumn);

    // Devolver los datos en formato JSON
    echo json_encode($datos);
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode([
        "error" => true,
        "mensaje" => $e->getMessage()
    ]);
}
