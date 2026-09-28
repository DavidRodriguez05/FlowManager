<?php
require_once __DIR__ . "/../../database/conexion.php";
require_once __DIR__ . "/../../includes/classes/selectAll.php";
require_once __DIR__ . "/../../../vendor/autoload.php";
require_once __DIR__ . '/../../config/load.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Conexión
$c = new conexion();
$conexion = $c->conectar();

// Selecciona todos los usuarios
$usuarios = mysqli_query($conexion, "SELECT id_usuario, email_usuario, nombre_usuario FROM usuarios");

while ($usuario = mysqli_fetch_assoc($usuarios)) {
  $id_usuario = $usuario['id_usuario'];
  $email = $usuario['email_usuario'];
  $nombre = $usuario['nombre_usuario'];

  // Busca tareas antiguas de este usuario
  $sqlTareas = "SELECT titulo_tarea, creacion_tarea 
                  FROM tareas 
                  WHERE id_usuario_tareas = $id_usuario 
                  AND creacion_tarea <= DATE_SUB(CURDATE(), INTERVAL 8 DAY)
                  AND estado_tarea != 'finalizada'";
  $tareas = mysqli_query($conexion, $sqlTareas);

  if (mysqli_num_rows($tareas) > 0) {
    // Prepara el listado de tareas
    $lista = '';
    while ($tarea = mysqli_fetch_assoc($tareas)) {
      $lista .= '<li><b>' . htmlspecialchars($tarea['titulo_tarea']) . '</b> (creada el ' . htmlspecialchars($tarea['creacion_tarea']) . ')</li>';
    }

    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = flowmanager_config()['mail']['username'];
      $mail->Password   = flowmanager_config()['mail']['password'];
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port       = 587;
      $mail->isHTML(true);

      $mail->setFrom(flowmanager_config()['mail']['from_email'], 'FlowManager');
      $mail->addAddress($email, $nombre);

      $mail->Subject = 'Tienes tareas pendientes de hace mas de 8 dias';
      $mail->Body = '
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f6f8;
      padding: 20px;
      color: #333;
    }
    .container {
      background-color: #ffffff;
      border-radius: 10px;
      padding: 30px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      text-align: center;
    }
    .logo {
      width: 60px;
      margin-bottom: 20px;
    }
    .footer {
      margin-top: 30px;
      font-size: 12px;
      color: #888;
    }
    ul {
      text-align: left;
      margin: 20px auto;
      display: inline-block;
      padding-left: 20px;
    }
    li {
      margin-bottom: 10px;
      font-size: 16px;
      background: #fef08a;
      color: #b45309;
      border-radius: 8px;
      padding: 8px 12px;
      list-style: disc inside;
    }
  </style>
</head>
<body>
  <div class="container">
    <img class="logo" src="https://cdn-icons-png.flaticon.com/512/1250/1250615.png" alt="FlowManager">
    <h2>¡Tienes tareas pendientes!</h2>
    <p>Hola ' . htmlspecialchars($nombre) . ', tienes las siguientes tareas pendientes desde hace mas de 8 dias:</p>
    <ul>' . $lista . '</ul>
    <p class="footer">Por favor, revisa tu gestor de tareas en FlowManager.</p>
  </div>
</body>
</html>
';

      $mail->send();
      // Puedes registrar que se ha enviado el email si quieres
    } catch (Exception $e) {
      // Puedes registrar el error si quieres
    }
  }
}
