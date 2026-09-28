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
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="shortcut icon" href="../../assets/img/FlowManager.png" type="image/x-icon">
    <title>Mis tareas</title>
</head>

<body class="dark:bg-gray-600">

    <?php
    include "./navegacionGestor.php";
    ?>

    <!-- Modal -->
    <div id="addTaskModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Agregar Nueva Tarea
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="addTaskModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Cerrar</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form action="procesar/crearTarea1.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="id_usuario" value="<?php echo $_SESSION["id"] ?>">
                        <div>
                            <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título de la tarea</label>
                            <input type="text" id="titulo" name="titulo" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Escribe el título" required>
                        </div>
                        <div>
                            <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                            <textarea id="descripcion" name="descripcion" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Escribe una descripción" required></textarea>
                        </div>
                        <div>
                            <label for="prioridad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prioridad</label>
                            <select id="prioridad" name="prioridad" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                <option value="baja">Baja</option>
                                <option value="media">Media</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>
                        <div>
                            <label for="estado" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
                            <select id="estado" name="estado" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                                <option value="suspendida">Suspendida</option>
                                <option value="progresando">Progresando</option>
                                <option value="finalizada">Finalizada</option>
                            </select>
                        </div>
                        <div>
                            <label for="archivo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Archivo adjunto de la tarea</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="archivo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h16m-5 4l4-4m0 0l-4-4"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Haz clic para subir</span> o arrastra un archivo</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PDF, DOCX, XLSX, PNG, JPG</p>
                                    </div>
                                    <input id="archivo" name="archivo" type="file" class="hidden" />
                                </label>
                            </div>
                            <div id="archivo-info" class="mt-5 flex items-center text-sm text-gray-500 dark:text-gray-400 hidden">
                                <span id="archivo-seleccionado"></span>
                                <button id="eliminar-archivo" type="button" class="ml-4 text-red-500 hover:text-red-700 text-lg">
                                    X
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-500 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar Tarea</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Aqui va todo el contenido editable -->
    <div class="p-3 md:ml-64 dark:bg-gray-600">
        <!-- Botón para abrir el modal -->
        <button data-modal-target="addTaskModal" data-modal-toggle="addTaskModal" class="text-white sm:m-4 cursor-pointer w-full sm:w-auto sm:min-w-64 md:min-w-72 lg:min-w-80 xl:min-w-96 h-12.5 bg-blue-800 flex justify-center items-center font-bold rounded-lg">
            <span>Agregar Tarea</span>
            <span class="ml-2 mr-2">
                <img src="../../assets/img/imganiadir.svg" alt="">
            </span>
        </button>
        <?php
        include "filtrosTareas.php"
        ?>
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-2 mt-6 mx-3">

            <?php
            $mostrarCarta = new selectAllClass;
            $mostrarCarta->mostrarTareasEA($_SESSION["id"]);

            ?>
            <!-- Carta de tarea -->
        </div>
        <?php
        include "../includes/functions/chatbot.php";
        include "../../tools/flowbitejs.html";
        ?>
        <script src="../../assets/js/validarRegistroTarea.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const archivoInput = document.getElementById("archivo");
                const archivoSeleccionado = document.getElementById("archivo-seleccionado");
                const archivoInfo = document.getElementById("archivo-info");
                const eliminarArchivo = document.getElementById("eliminar-archivo");

                archivoInput.addEventListener("change", function() {
                    if (archivoInput.files.length > 0) {
                        archivoSeleccionado.textContent = `Archivo seleccionado: ${archivoInput.files[0].name}`;
                        archivoInfo.classList.remove("hidden");
                    } else {
                        archivoSeleccionado.textContent = "";
                        archivoInfo.classList.add("hidden");
                    }
                });

                eliminarArchivo.addEventListener("click", function() {
                    archivoInput.value = ""; // Resetea el input de archivo
                    archivoSeleccionado.textContent = "";
                    archivoInfo.classList.add("hidden");
                });
            });
        </script>
</body>

</html>