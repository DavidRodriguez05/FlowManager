<?php
require_once "../includes/sessions/verificarJS.php";
require_once "../includes/sessions/sesionInicio.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include "../../tools/flowbitecss.html";
    ?>
    <link rel="stylesheet" href="../dashboard/dist/assets/index-9GWPTkkq.css">
    <link rel="shortcut icon" href="../../assets/img/FlowManager.png" type="image/x-icon">
    <title>Dashboard</title>
</head>

<body class="dark:bg-gray-600">

    <?php
    include "./navegacionGestor.php";
    ?>

    <!-- Aqui va todo el contenido editable -->
    <div id="root" class="p-3 md:ml-64 dark:bg-gray-600">
    </div>
    <?php
    include "../../tools/flowbitejs.html";
    ?>
    <script type="module" src="../dashboard/dist/assets/index-D00tJO1m.js"></script>
</body>

</html>