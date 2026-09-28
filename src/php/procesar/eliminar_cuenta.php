<?php
require_once "../../includes/sessions/verificarJS.php";
require_once "../../includes/sessions/sesionInicio.php";
require_once "../../includes/classes/deleteAll.php";
require_once "../../database/conexion.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id_usuario'])) {
    echo "<script>window.history.back();</script>";
    exit;
}
$id_usuario = $_POST["id_usuario"];
$objetoEliminarCuenta = new delete;
$eliminarCuenta = $objetoEliminarCuenta->eliminarCuenta($id_usuario);
if ($eliminarCuenta == true) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    header('Location: ../../keys/inicioCuenta.php');
}
