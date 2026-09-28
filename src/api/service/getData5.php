<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once "../../database/conexion.php";
require_once "../../includes/classes/selectAll.php";

try {
    $selectAll = new selectAllClass();
    $datos = $selectAll->selectAllProjectDataLast("proyectos");

    // Truncar el nombre del proyecto a 10 caracteres con puntos suspensivos
    foreach ($datos as &$item) {
        if (isset($item['nombre_proyecto']) && mb_strlen($item['nombre_proyecto']) > 10) {
            $item['nombre_proyecto'] = mb_substr($item['nombre_proyecto'], 0, 10) . '...';
        }
    }

    echo json_encode($datos);
} catch (Exception $e) {
    echo json_encode([
        "error" => true,
        "mensaje" => $e->getMessage()
    ]);
}
