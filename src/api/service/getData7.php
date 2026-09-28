<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once "../../database/conexion.php";
require_once "../../includes/classes/selectAll.php";

try {
    $selectAll = new selectAllClass();
    $tabla = "tareas";
    $fechaColumn = "creacion_tarea";
    $datos = $selectAll->selectNewestTasks($tabla, $fechaColumn);

    // Truncar el título a 10 caracteres con puntos suspensivos
    foreach ($datos as &$item) {
        if (mb_strlen($item['titulo_tarea']) > 10) {
            $item['titulo_tarea'] = mb_substr($item['titulo_tarea'], 0, 10) . '...';
        }
    }

    echo json_encode($datos);
} catch (Exception $e) {
    echo json_encode([
        "error" => true,
        "mensaje" => $e->getMessage()
    ]);
}
