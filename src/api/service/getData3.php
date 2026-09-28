<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once "../../database/conexion.php";
require_once "../../includes/classes/selectAll.php";

try {
    $selectAll = new selectAllClass();
    $datos = $selectAll->selectAllTaskCount("tareas");
    echo json_encode($datos);
} catch (Exception $e) {
    echo json_encode([
        "error" => true,
        "mensaje" => $e->getMessage()
    ]);
}
