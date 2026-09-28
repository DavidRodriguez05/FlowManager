<?php
require_once "../includes/sessions/verificarJS.php";
session_start();
if (isset($_SESSION['usuario'])) {
    // Redirige al usuario al dashboard si ya está logueado
    header("Location: https://cdmdavidro.es/src/php/gestor.php");
    exit();
}
require_once "../database/conexion.php";
require_once "../includes/classes/selectAll.php";

$error = false; // Variable para controlar si hay un error

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $selectUsuarios = new selectAllClass();
    $selectUsuariosSelectAll = $selectUsuarios->selectAll("usuarios");

    foreach ($selectUsuariosSelectAll as $valor) {
        if ($valor['email_usuario'] == $email && password_verify($password, $valor['password_usuario'])) {
            $_SESSION['id'] = $valor['id_usuario'];
            $_SESSION['usuario'] = $valor['nombre_usuario'];
            $_SESSION['email'] = $valor['email_usuario'];
            $_SESSION['avatar'] = $valor['avatar_usuario'];
            $_SESSION['rol'] = $valor['rol_usuario'];
            header("Location: https://cdmdavidro.es/src/php/gestor.php");
            exit();
        }
    }

    // Si no coincide, activa el error
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include "../../tools/flowbitecss.html";
    ?>
    <link rel="shortcut icon" href="../../assets/img/FlowManager.png" type="image/x-icon">
    <title>Iniciar Sesión</title>
</head>

<body>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-8 h-8 mr-2" src="https://cdmdavidro.es/assets/img/FlowManager.png" alt="logo">
                FlowManager
            </a>
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-800">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Inicia sesión en tu cuenta
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="./inicioCuenta.php" method="post">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tu email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-blue-600 <?php echo $error ? 'border-red-500' : 'border-blue-400'; ?> text-gray-900 rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600" placeholder="nombre@extension.com" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-blue-600 <?php echo $error ? 'border-red-500' : 'border-blue-400'; ?> text-gray-900 rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600" placeholder="••••••••" required="">
                        </div>
                        <?php if ($error): ?>
                            <p class="text-sm text-red-500">Usuario o contraseña incorrectos.</p>
                        <?php endif; ?>
                        <div class="flex items-center justify-between">
                            <a href="olvideMiPassword.php" class="text-sm font-medium text-blue-400 hover:underline dark:text-blue-300">¿Olvidaste tu contraseña?</a>
                        </div>
                        <input type="submit" value="Iniciar Sesión" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            ¿No tienes una cuenta todavía? <a href="./registroCuenta.php" class="text-sm font-medium text-blue-400 hover:underline dark:text-blue-300">Regístrate</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
    include "../../tools/flowbitejs.html"
    ?>
</body>

</html>