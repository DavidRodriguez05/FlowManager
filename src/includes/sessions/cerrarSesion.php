<?php
// Este método para destruir sesiones viene en la documentación de PHP:
// https://www.php.net/manual/es/function.session-destroy.php
session_start();
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
//header('Location: login.php');
?>
<script>
    window.location.href = "../../keys/inicioCuenta.php";
</script>