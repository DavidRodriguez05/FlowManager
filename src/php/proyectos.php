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
    <?php include "../../tools/flowbitecss.html"; ?>
    <link rel="shortcut icon" href="../../assets/img/FlowManager.png" type="image/x-icon">
    <title>Mis proyectos</title>
</head>

<body class="dark:bg-gray-600">
    <?php include "./navegacionGestor.php"; ?>

    <!-- Modal para crear nuevo proyecto -->
    <div id="addProjectModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Crear Nuevo Proyecto
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="addProjectModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Cerrar</span>
                    </button>
                </div>
                <div class="p-6 space-y-6">
                    <form action="procesar/crearProyecto1.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="id_usuario" value="<?php echo $_SESSION["id"] ?>">
                        <div>
                            <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del Proyecto</label>
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
                                <option value="activo">Activo</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="completado">Completado</option>
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

    <!-- Modal Unirme a Proyecto -->
    <div id="modalUnirmeProyecto" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300 hidden">
        <div class="bg-gradient-to-br from-zinc-900 via-zinc-800 to-zinc-900 w-full max-w-md p-8 rounded-2xl shadow-2xl border border-zinc-700 relative text-white">
            <h2 class="text-2xl font-bold mb-6">Unirme a un Proyecto</h2>
            <form action="procesar/unirmeProyecto.php" method="POST" class="space-y-5">
                <div>
                    <input type="hidden" name="id_usuario" value="<?php echo $_SESSION["id"] ?>">
                    <label class="block text-sm text-zinc-400 mb-1">Código del proyecto</label>
                    <input type="text" name="codigo_proyecto" required
                        class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white placeholder-zinc-400 
                    outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                        placeholder="Introduce el código">
                </div>
                <div class="flex justify-end gap-4 pt-4">
                    <button type="button" onclick="cerrarModalUnirmeProyecto()"
                        class="px-4 py-2 rounded-lg bg-zinc-600 text-white hover:bg-zinc-500 transition duration-200">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 text-white hover:from-purple-500 hover:to-blue-500 transition duration-200">
                        Unirme
                    </button>
                </div>
                <!-- Botón cerrar (X) -->
                <button type="button" onclick="cerrarModalUnirmeProyecto()"
                    class="absolute top-3 right-4 text-zinc-400 hover:text-white text-2xl font-bold">
                    &times;
                </button>
            </form>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="p-3 md:ml-64 dark:bg-gray-600">
        <?php if (isset($_SESSION['msg'])): ?>
            <div id="mensaje-flotante"
                class="w-full flex justify-center transition-all duration-500">
                <div id="mensaje-flotante-contenido"
                    class="my-4 px-6 py-3 rounded-lg shadow-lg text-white text-center text-lg font-semibold
            <?php
            $colores = [
                'success' => 'bg-green-500',
                'error' => 'bg-red-500',
                'warning' => 'bg-yellow-500'
            ];
            echo $colores[$_SESSION['msg']['tipo']];
            ?>">
                    <?= $_SESSION['msg']['texto'] ?>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    const msg = document.getElementById('mensaje-flotante');
                    if (msg) msg.style.display = 'none';
                }, 3000);
            </script>
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>
        <div class="flex flex-wrap gap-4 m-4 justify-center items-center">
            <!-- Botón Agregar Proyecto -->
            <button data-modal-target="addProjectModal" data-modal-toggle="addProjectModal"
                class="text-white cursor-pointer w-full sm:w-auto sm:min-w-64 md:min-w-72 lg:min-w-80 xl:min-w-96 h-12.5 bg-blue-800 flex justify-center items-center font-bold rounded-lg">
                <span>Agregar Proyecto</span>
                <span class="ml-2 mr-2">
                    <img src="../../assets/img/imganiadir.svg" alt="">
                </span>
            </button>

            <!-- Botón Unirme a Proyecto -->
            <button
                onclick="abrirModalUnirmeProyecto()"
                class="text-white cursor-pointer w-full sm:w-auto sm:min-w-64 md:min-w-72 lg:min-w-80 xl:min-w-96 h-12.5 bg-blue-700 flex justify-center items-center font-bold rounded-lg transition hover:bg-blue-800">
                <span>Unirme a Proyecto</span>
                <span class="ml-2 mr-2">
                    <!-- SVG de usuario con plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="28" height="28">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2" fill="none" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 8v6m3-3h-6" />
                    </svg>
                </span>
            </button>
        </div>

        <!-- Cartas de proyectos -->
        <?php
        $mostrar = new selectAllClass();
        $mostrar->mostrarProyectosUsuario($_SESSION["id"]);
        ?>

        <?php
        include "../includes/functions/chatbot.php";
        include "../../tools/flowbitejs.html";
        ?>
        <script src="../../assets/js/validarRegistroProyecto.js"></script>

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

            function abrirModalUnirmeProyecto() {
                document.getElementById('modalUnirmeProyecto').classList.remove('hidden');
            }

            function cerrarModalUnirmeProyecto() {
                document.getElementById('modalUnirmeProyecto').classList.add('hidden');
            }
        </script>
</body>

</html>