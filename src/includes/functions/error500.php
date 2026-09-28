<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../../../assets/img/FlowManager.png" type="image/x-icon">
    <title>Error interno del servidor</title>
    <?php include "../../../tools/flowbitecss.html"; ?>
</head>

<body class="bg-[#1f2937] text-white flex items-center justify-center min-h-screen">
    <div class="bg-[#111827] p-10 rounded-2xl shadow-lg max-w-md w-full text-center">
        <h1 class="text-6xl font-bold text-pink-400 mb-4">500</h1>
        <h2 class="text-2xl font-semibold mb-2">Error interno del servidor</h2>
        <p class="text-gray-400 mb-6">
            Ha ocurrido un error inesperado. Por favor, inténtalo de nuevo más tarde.
        </p>
        <button onclick="window.history.back();" class="inline-block bg-orange-500 hover:bg-orange-600 transition px-6 py-2 rounded-full font-semibold text-white">
            Volver atrás
        </button>
    </div>
    <?php include "../../../tools/flowbitejs.html"; ?>
</body>

</html>