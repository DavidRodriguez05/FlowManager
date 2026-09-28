<?php
session_start();

// Verifica si existe una sesión activa
if (!isset($_SESSION['usuario']) && !isset($_SESSION['email'])) {
    // Si no existe sesión, redirige al usuario a la página de inicio de sesión
    header("Location: https://cdmdavidro.es/src/keys/registroCuenta.php");
}
