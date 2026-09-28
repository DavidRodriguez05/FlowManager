<?php
require_once "../includes/sessions/verificarJS.php";
session_start();
if (isset($_SESSION['usuario'])) {
    // Redirige al usuario al dashboard si ya está logueado
    header("Location: https://cdmdavidro.es/src/php/gestor.php");
    exit();
}
if (!isset($_SESSION["codigo_recuperacion"]) || !$_SESSION["codigo_recuperacion"]) {
    header("Location: https://cdmdavidro.es/src/keys/olvideMiPassword.php");
    exit();
}
$codigoCorrecto = true;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo'])) {
    $codigo = $_POST["codigo"];

    if ($codigo == $_SESSION["codigo_recuperacion"]) {
        $codigoCorrecto = true;
        $_SESSION["codigo_validado"] = true;
        header("Location: https://cdmdavidro.es/src/keys/olvideMiPassword3.php");
        exit();
    } else {
        $codigoCorrecto = false;
    }
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
    <title>Olvide mi contraseña</title>
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
                    Codigo de recuperacion
                </h1>
                <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" enctype="multipart/form-data" method="post" action="#">
                    <div>
                        <label for="codigo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tu código de recuperación</label>
                        <input type="number" name="codigo" id="codigo" class="bg-gray-50 border border-blue-600 text-gray-900 rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-600 dark:focus:border-blue-600" placeholder="123456" required="">
                    </div>
                    <?php
                    if ($codigoCorrecto == true) {
                    } else {
                    ?>
                        <p class="font-light text-gray-500 dark:text-red-400">
                            Ese codigo no es correcto, por favor vuelve a intentarlo.
                        </p>
                    <?php
                    }
                    ?>
                    <input type="submit" value="Validar codigo" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                </form>
            </div>
        </div>
    </section>
    <?php
    include "../../tools/flowbitejs.html";
    ?>
</body>

</html>