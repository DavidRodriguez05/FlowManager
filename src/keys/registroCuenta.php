<?php
require_once "../includes/sessions/verificarJS.php";
session_start(); // Inicia la sesión

// Verifica si ya existe una sesión activa
if (isset($_SESSION['usuario'])) {
    // Redirige al usuario al dashboard si ya está logueado
    header("Location: https://cdmdavidro.es/src/php/gestor.php");
    exit();
}
require_once "../database/conexion.php";
require_once "../includes/classes/insertInto.php";

$errorFormatoArchivo = ""; // Variable para almacenar el mensaje de error

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm-password'])) {
    $nombre = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $confirm_password = password_hash($_POST['confirm-password'], PASSWORD_BCRYPT);

    if (isset($_FILES['username-file']) && $_FILES['username-file']['error'] === UPLOAD_ERR_OK) {
        $avatar = $_FILES['username-file']['name'];

        $extension = pathinfo($avatar, PATHINFO_EXTENSION); // Obtiene la extensión del archivo

        // Lista de extensiones de imagen permitidas
        $extensionesPermitidas = ['jpg', 'jpeg', 'png'];

        if (!in_array(strtolower($extension), $extensionesPermitidas)) {
            $errorFormatoArchivo = "El formato del archivo no es válido. Solo se permiten imágenes (jpg, jpeg, png).";
            $avatar = null; // No guardar el archivo si no es válido
        } else {
            // Ruta de la carpeta donde se guardará la imagen

            // Mueve el archivo subido a la carpeta destino
            if (move_uploaded_file($_FILES['username-file']['tmp_name'], "../../assets/img/usuarios/" . $_FILES['username-file']['name'])) {
                // El archivo se movió correctamente
            } else {
                $errorFormatoArchivo = "Hubo un error al subir el archivo. Inténtalo de nuevo.";
                $avatar = null;
            }
        }
    }

    if (isset($avatar)) {
        $informacion = [$nombre, $email, $password, $avatar];
    } else {
        $informacion = [$nombre, $email, $password];
    }

    if (empty($errorFormatoArchivo)) { // Solo insertar si no hay errores
        $insertar = new insertarDatosClass();
        if ($insertar->insertar($informacion)) {
            session_destroy();
            header("Location: https://cdmdavidro.es/src/keys/inicioCuenta.php");
            exit();
        } else {
            die("Error al insertar el usuario en la base de datos.");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include "../../tools/flowbitecss.html"
    ?>
    <link rel="shortcut icon" href="../../assets/img/FlowManager.png" type="image/x-icon">
    <title>Registro de cuenta</title>
    <style>
        .erroneo {
            color: red;
            font-size: 14px;
        }

        .erroneo::before {
            content: "❌";
        }

        .correcto {
            color: #00D26A;
            font-size: 14px;
        }

        .correcto::before {
            content: "✅";
        }
    </style>
</head>

<body>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-auto min-h-[100vh] lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-8 h-8 mr-2" src="https://cdmdavidro.es/assets/img/FlowManager.png" alt="logo">
                FlowManager
            </a>
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-800">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Crea una cuenta
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="./registroCuenta.php" method="post" enctype="multipart/form-data">
                        <div>
                            <label id="usernameLabel" for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de usuario</label>
                            <input type="text" name="username" id="username" class="bg-gray-50 border border-blue-600 text-gray-900 rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-gray-700 dark:border-blue-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600" placeholder="Tu nombre de usuario" required="">
                        </div>
                        <div>
                            <label id="emailLabel" for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tu email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-blue-600 text-gray-900 rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-gray-700 dark:border-blue-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600" placeholder="nombre@extension.com" required="">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label id="passwordLabel" for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contraseña</label>
                                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-blue-600 text-gray-900 rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-gray-700 dark:border-blue-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600" required="">
                            </div>
                            <div>
                                <label id="confirmPasswordLabel" for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirma tu contraseña</label>
                                <input type="password" name="confirm-password" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-blue-600 text-gray-900 rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-gray-700 dark:border-blue-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600" required="">
                            </div>
                        </div>
                        <div>
                            <label id="username-fileLabel" for="username-file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sube tu avatar</label>
                            <input type="file" name="username-file" id="username-file" accept=".jpg,.jpeg,.png" class="bg-gray-50 border border-blue-600 text-gray-900 rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-gray-700 dark:border-blue-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600">
                        </div>
                        <?php if (!empty($errorFormatoArchivo)) : ?>
                            <p class="text-sm text-red-600 dark:text-red-400"><?php echo $errorFormatoArchivo; ?></p>
                        <?php endif; ?>
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-blue-600 rounded bg-gray-50 text-blue-600 focus:ring-3 focus:ring-blue-400 checked:bg-blue-600 checked:border-blue-600 dark:bg-gray-700 dark:border-blue-600 dark:focus:ring-blue-600 dark:checked:bg-blue-600 dark:checked:border-blue-600 dark:ring-offset-gray-800" required="">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-light text-gray-500 dark:text-gray-300">Acepto los <a class="font-medium text-blue-400 hover:underline dark:text-blue-300" href="#">Términos y Condiciones</a></label>
                            </div>
                        </div>
                        <input id="registrarBoton" type="submit" value="Crear cuenta" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            ¿Ya tienes una cuenta? <a href="./inicioCuenta.php" class="font-medium text-blue-400 hover:underline dark:text-blue-300">Inicia sesión aquí</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
    include "../../tools/flowbitejs.html"
    ?>
    <script src="../../assets/js/validarRegistroCuenta.js"></script>
</body>

</html>