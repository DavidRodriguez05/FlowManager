<?php
require_once "../../includes/sessions/verificarJS.php";
require_once "../../includes/sessions/sesionInicio.php";
require_once "../../database/conexion.php";
require_once "../../includes/classes/deleteAll.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_proyecto'])) {
    echo "<script>window.history.back();</script>";
    exit;
}

$id_proyecto = $_POST["id_proyecto"];

$eliminarTarea = new delete();
$resultado = $eliminarTarea->eliminarProyecto($id_proyecto);

if ($resultado !== true) {
    echo "<div style='min-height:100vh; display:flex; align-items:center; justify-content:center; background:#1e1e1e; color:white; font-family:sans-serif; flex-direction:column; text-align:center;'>
            <h2 style='font-size:24px; margin-bottom:16px;'>$resultado</h2>
            <a href='javascript:history.back()' style='padding:10px 20px; background:#444; border-radius:8px; color:white; text-decoration:none;'>Volver</a>
            </div>";
    exit;
}

echo "<script>
    window.location.href='../proyectos.php';
</script>";
