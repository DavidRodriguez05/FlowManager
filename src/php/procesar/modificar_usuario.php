<?php
require_once "../../includes/sessions/verificarJS.php";
require_once "../../includes/sessions/sesionInicio.php";
require_once "../../database/conexion.php";
require_once "../../includes/classes/updateAll.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "<script>
    window.history.back();
</script>";
    exit;
}

$id_usuario = $_POST["id_usuario"];
$nombre = $_POST["nombre"];

// Obtener el avatar actual del usuario
$c = new conexion();
$conexion = $c->conectar();
$sql = "SELECT avatar_usuario FROM usuarios WHERE id_usuario = " . intval($id_usuario);
$res = mysqli_query($conexion, $sql);
$usuario = mysqli_fetch_assoc($res);
$avatarActual = $usuario["avatar_usuario"];

// Procesar el nuevo avatar si se subió uno
$nuevoAvatar = $avatarActual;
if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] === UPLOAD_ERR_OK) {
    $nombreArchivo = $_FILES["avatar"]["name"];
    $tmpArchivo = $_FILES["avatar"]["tmp_name"];
    $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
    $permitidas = ["jpg", "jpeg", "png"];

    if (in_array($extension, $permitidas)) {
        // Elimina el avatar anterior si existe, no es null y no es el avatar por defecto
        if (
            $avatarActual &&
            $avatarActual !== "avatarNULL.png" &&
            strtolower($avatarActual) !== "null" &&
            file_exists("../../../assets/img/usuarios/" . $avatarActual)
        ) {
            unlink("../../../assets/img/usuarios/" . $avatarActual);
        }
        // Guarda el nuevo avatar
        $nuevoNombre = "avatar_" . $id_usuario . "_" . time() . "." . $extension;
        move_uploaded_file($tmpArchivo, "../../../assets/img/usuarios/" . $nuevoNombre);
        $nuevoAvatar = $nuevoNombre;
    }
}

// Actualizar usuario
$update = new updateAllClass();
$datos = [$nombre, $nuevoAvatar];
$update->modificarUsuario($id_usuario, $datos);

// Redirigir o mostrar mensaje

echo "<script>
    window.location = '../miPerfil.php';
</script>";
exit;
