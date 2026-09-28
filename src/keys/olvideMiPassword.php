<?php
require_once "../includes/sessions/verificarJS.php";
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Ajusta esta ruta si composer.json no está 2 carpetas arriba
require_once __DIR__ . '/../config/load.php';

if (isset($_SESSION['usuario'])) {
    header("Location: https://cdmdavidro.es/src/php/gestor.php");
    exit();
}

$booleanEmailExiste = true;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    require_once "../database/conexion.php";
    require_once "../includes/classes/selectAll.php";

    $email = $_POST['email'];
    $existeEmail = new selectAllClass();
    $resultado = $existeEmail->selectAllWhere("usuarios", "email_usuario = '$email'");

    if (count($resultado) == 0) {
        $booleanEmailExiste = false;
    } else {
        $booleanEmailExiste = true;
        $codigo = rand(100000, 999999);

        $_SESSION['codigo_recuperacion'] = $codigo;
        $_SESSION['email_recuperacion'] = $email;

        // Enviar correo con PHPMailer
        $mail = new PHPMailer(exceptions: true);
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

            $mail->Subject = 'Codigo para recuperacion de password';
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
    <h2>Recuperación de contraseña</h2>
    <p>Hemos recibido una solicitud para recuperar tu contraseña.</p>
    <p>Introduce el siguiente código en la plataforma:</p>
    <div class="code">' . $codigo . '</div>
    <p class="footer">Si tú no solicitaste este cambio, puedes ignorar este mensaje.</p>
  </div>
</body>
</html>
';

            $mail->send();
            header("Location: https://cdmdavidro.es/src/keys/olvideMiPassword2.php");
            exit();
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include "../../tools/flowbitecss.html";
    ?>
    <link rel="shortcut icon" href="../../assets/img/FlowManager.png" type="image/x-icon">
    <title>Recuperar Contraseña</title>
</head>

<body>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-8 h-8 mr-2" src="https://cdmdavidro.es/assets/img/FlowManager.png" alt="logo">
                FlowManager
            </a>
            <div class="w-full p-6 bg-white rounded-lg shadow md:mt-0 sm:max-w-md dark:bg-gray-800 sm:p-8">
                <h1 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    ¿Olvidaste tu contraseña?
                </h1>
                <p class="font-light text-gray-500 dark:text-gray-400">
                    ¡No te preocupes! Escribe tu correo electrónico y te enviaremos un código para restablecer tu contraseña.
                </p>
                <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" enctype="multipart/form-data" method="post" action="#">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tu correo electrónico</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-blue-600 text-gray-900 rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600" placeholder="nombre@correo.com" required="">
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-blue-600 rounded bg-gray-50 text-blue-600 focus:ring-3 focus:ring-blue-300 checked:bg-blue-600 checked:border-blue-600 dark:bg-gray-700 dark:border-blue-600 dark:focus:ring-blue-500 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:ring-offset-gray-800" required="">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-light text-gray-500 dark:text-gray-300">
                                Acepto los <a class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="#">Términos y Condiciones</a>
                            </label>
                        </div>

                    </div>
                    <?php
                    if ($booleanEmailExiste == true) {
                    } else {
                    ?>
                        <p class="font-light text-gray-500 dark:text-red-400">
                            Ese email no existe o no esta registrado
                        </p>
                    <?php
                    }
                    ?>
                    <input type="submit" value="Restablecer contraseña" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                </form>
            </div>
        </div>
    </section>
    <?php
    include "../../tools/flowbitejs.html";
    ?>
</body>

</html>