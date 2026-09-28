<?php
require_once "../../includes/sessions/verificarJS.php";
require_once "../../includes/sessions/sesionInicio.php";
require_once "../../includes/classes/updateAll.php";
require_once "../../database/conexion.php";

$id_usuario = $_POST["id_usuario"];
$password = $_POST["nueva_password"];

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

$objetoCambioPassword = new updateAllClass;
$cambioPassword = $objetoCambioPassword->modificarPassword($id_usuario, $passwordHash);
