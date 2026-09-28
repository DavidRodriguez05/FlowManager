<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<?php
require_once "../../includes/sessions/verificarJS.php";
require_once "../../includes/sessions/sesionInicio.php";
require_once "../../database/conexion.php";
require_once "../../includes/classes/insertInto.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_tarea'])) {
    echo "<script>window.history.back();</script>";
    exit;
}


$id_tarea = $_POST["id_tarea"];
$nombreArchivo = $_FILES["archivo"]["name"];
$tamanioArchivo = $_FILES["archivo"]["size"];
$extensionArchivo = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
$extensionesPermitidas = ["pdf", "docx", "xlsx", "png", "jpg", "jpeg"];
$tamanioMaximo = 15 * 1024 * 1024;

if (!in_array($extensionArchivo, $extensionesPermitidas)) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

// Validar tamaño
if ($tamanioArchivo > $tamanioMaximo) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

$rutaCarpeta = "../../archive/tareas/";
$rutaArchivo = $rutaCarpeta . $nombreArchivo;
if (file_exists($rutaArchivo)) {
    $nombreArchivo = pathinfo($nombreArchivo, PATHINFO_FILENAME) . "_" . uniqid() . "." . $extensionArchivo;
    $rutaArchivo = $rutaCarpeta . $nombreArchivo;
}

if (!move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaArchivo)) {
    echo "
        <div class='flex flex-col items-center justify-center min-h-screen bg-blue-100'>
            <div class='bg-red-400 text-white font-bold rounded-lg border shadow-lg p-10'>
                <p>Error al mover el archivo al servidor.</p>
                <a href='javascript:history.back()' class='mt-4 inline-block bg-white text-red-400 font-medium py-2 px-4 rounded hover:bg-gray-200'>Volver atrás</a>
            </div>
        </div>";
    exit;
} else {
    $datosArchivoTarea = [$nombreArchivo, $extensionArchivo];

    $insertarDatosArchivo = new insertarDatosClass;
    $insertarDatosArchivo->insertarArchivoTarea($id_tarea, $datosArchivoTarea);
}
$_SESSION["id_tarea"] = $id_tarea;
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;

?>