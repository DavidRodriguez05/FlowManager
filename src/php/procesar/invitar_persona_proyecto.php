<?php
require_once "../../includes/sessions/verificarJS.php";
require_once "../../includes/sessions/sesionInicio.php";
require_once "../../database/conexion.php";
require_once "../../includes/classes/selectAll.php";
require_once "../../../vendor/autoload.php";
require_once __DIR__ . '/../../config/load.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  echo "<script>window.history.back();</script>";
  exit;
}

$id_proyecto = $_POST["id_proyecto"];
$email = $_POST["email"];

$obtenerCodigoProyecto = new selectAllClass;
$codigo_proyecto = $obtenerCodigoProyecto->obtenerCodigoProyecto($id_proyecto);

// Enviar correo con PHPMailer
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
  $mail->addAddress($email);

  $mail->Subject = 'Invitacion a un proyecto en FlowManager';
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
    .code {
      font-size: 32px;
      font-weight: bold;
      background-color: #e0f2fe;
      color: #0284c7;
      display: inline-block;
      padding: 10px 20px;
      border-radius: 8px;
      margin-top: 20px;
    }
    .footer {
      margin-top: 30px;
      font-size: 12px;
      color: #888;
    }
  </style>
</head>
<body>
  <div class="container">
    <img class="logo" src="https://cdn-icons-png.flaticon.com/512/1250/1250615.png" alt="FlowManager">
    <h2>Invitacion a un proyecto</h2>
    <p>Te han invitado a un proyecto en FlowManager.</p>
    <p>Utiliza el siguiente codigo para unirte:</p>
    <div class="code">' . htmlspecialchars($codigo_proyecto) . '</div>
    <p class="footer">Si no esperabas esta invitación, puedes ignorar este mensaje.</p>
  </div>
</body>
</html>
';

  $mail->send();
  header("Location: https://cdmdavidro.es/src/php/proyectos.php");
  exit();
} catch (Exception $e) {
  echo "<div style='color:red;text-align:center;margin-top:40px;'>Error al enviar el correo: {$mail->ErrorInfo}</div>";
}
