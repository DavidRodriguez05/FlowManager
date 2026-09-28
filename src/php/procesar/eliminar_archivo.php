<?php
require_once "../../includes/sessions/verificarJS.php";
require_once "../../includes/sessions/sesionInicio.php";
require_once "../../includes/classes/deleteAll.php";
require_once "../../database/conexion.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_archivo'])) {
    echo "<script>window.history.back();</script>";
    exit;
}


$eliminarArchivo = new delete;
$eliminarArchivo->eliminarArchivoTarea($_POST["id_archivo"], $_POST["id_tarea"]);
