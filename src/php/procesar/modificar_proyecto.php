<?php
require_once "../../includes/sessions/verificarJS.php";
require_once "../../includes/sessions/sesionInicio.php";
require_once "../../database/conexion.php";
require_once "../../includes/classes/updateAll.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "<script>window.history.back();</script>";
    exit;
}

$id_proyecto = $_POST["id_proyecto"];
$nombre_proyecto = $_POST["nombre_proyecto"];
$descripcion_proyecto = $_POST["descripcion_proyecto"];
$prioridad_proyecto = $_POST["prioridad_proyecto"];
$estado_proyecto = $_POST["estado_proyecto"];

if (mb_strlen($nombre_proyecto) > 150) {
    echo '
    <div style="display:flex;align-items:center;justify-content:center;height:100vh;background:linear-gradient(135deg,#f8fafc 0%,#e0e7ff 100%);">
        <div style="background:#fff;padding:2.5rem 3.5rem;border-radius:16px;box-shadow:0 8px 32px rgba(60,72,100,0.18);text-align:center;max-width:400px;">
            <div style="font-size:3rem;margin-bottom:0.5rem;color:#dc3545;">&#9888;</div>
            <h2 style="color:#dc3545;margin-bottom:0.5rem;font-family:sans-serif;">¡Error!</h2>
            <p style="color:#333;margin-bottom:1.5rem;font-size:1.1rem;">El <b>nombre del proyecto</b> no puede superar los <b>150 caracteres</b>.</p>
            <a href="../proyectos.php" style="display:inline-block;padding:0.7rem 2rem;background:linear-gradient(90deg,#6366f1 0%,#2563eb 100%);color:#fff;text-decoration:none;border-radius:8px;font-weight:600;box-shadow:0 2px 8px rgba(60,72,100,0.10);transition:background 0.2s;">Volver a proyectos</a>
        </div>
    </div>
    ';
    exit;
}

$datos = [$nombre_proyecto, $descripcion_proyecto, $prioridad_proyecto, $estado_proyecto];

$modificarDatos = new updateAllClass;
$modificarDatos->modificarProyecto($id_proyecto, $datos);
