<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../../../assets/img/FlowManager.png" type="image/x-icon">
    <title>Solicitud incorrecta</title>
    <?php include "../../../tools/flowbitecss.html"; ?>
</head>

<body class="bg-[#1f2937] text-white flex items-center justify-center min-h-screen">
    <div class="bg-[#111827] p-10 rounded-2xl shadow-lg max-w-md w-full text-center">
        <h1 class="text-6xl font-bold text-yellow-400 mb-4">400</h1>
        <h2 class="text-2xl font-semibold mb-2">Solicitud incorrecta</h2>
        <p class="text-gray-400 mb-6">
            La solicitud enviada no es válida o está mal formada.
        </p>
        <button onclick="window.history.back();" class="inline-block bg-orange-500 hover:bg-orange-600 transition px-6 py-2 rounded-full font-semibold text-white">
            Volver atrás
        </button>
    </div>
    <?php include "../../../tools/flowbitejs.html"; ?>
</body>

</html>