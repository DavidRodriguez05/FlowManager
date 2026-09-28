<?php
require_once "../includes/sessions/verificarJS.php";
require_once "../includes/sessions/sesionInicio.php";
require_once "../includes/classes/selectAll.php";
require_once "../database/conexion.php";
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
    <title>Mis notificaciones</title>
</head>

<body class="dark:bg-gray-600">

    <?php
    include "./navegacionGestor.php";
    ?>

    <div class="p-3 md:ml-64 dark:bg-gray-600">
        <?php
        $mostrarTareasFecha = new selectAllClass;
        $mostrarTareasFecha->mostrarTareasTiempo($_SESSION["id"]);
        ?>
    </div>
    <?php
    include "../includes/functions/chatbot.php";
    include "../../tools/flowbitejs.html";
    ?>
</body>

</html>