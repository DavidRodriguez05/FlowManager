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

    // Obtener la cantidad de tareas por semana del mes actual
    $tabla = "tareas"; // Cambia esto por el nombre de tu tabla
    $fechaColumn = "creacion_tarea"; // Cambia esto por el nombre de la columna de fecha
    $datos = $selectAll->selectTasksByWeek($tabla, $fechaColumn);

    // Devolver los datos en formato JSON
    echo json_encode($datos);
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode([
        "error" => true,
        "mensaje" => $e->getMessage()
    ]);
}
