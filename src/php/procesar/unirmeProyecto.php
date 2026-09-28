<?php
require_once "../../includes/sessions/verificarJS.php";
require_once "../../includes/sessions/sesionInicio.php";
require_once "../../database/conexion.php";
require_once "../../includes/classes/selectAll.php";
require_once "../../includes/classes/insertInto.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "<script>window.history.back();</script>";
    exit;
}

$id_usuario = $_POST["id_usuario"];
$codigo_proyecto = $_POST["codigo_proyecto"];

$selecionar = new selectAllClass;
$insertar = new insertarDatosClass;

// 1. Obtener el id del proyecto por el código
$id_proyecto = $selecionar->obtenerIdProyectoPorCodigo($codigo_proyecto);

if ($id_proyecto === null) {
    $_SESSION['msg'] = ['tipo' => 'error', 'texto' => 'El código de proyecto no existe.'];
    header("Location: ../proyectos.php");
    exit;
}
if ($selecionar->usuarioYaUnidoAProyecto($id_usuario, $id_proyecto)) {
    $_SESSION['msg'] = ['tipo' => 'warning', 'texto' => 'Ya estás unido a este proyecto.'];
    header("Location: ../proyectos.php");
    exit;
}
$insertar->vincularProyectoUsuario($id_usuario, $id_proyecto);
$_SESSION['msg'] = ['tipo' => 'success', 'texto' => '¡Te has unido al proyecto correctamente!'];
header("Location: ../proyectos.php");
exit;
