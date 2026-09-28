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
    <title>Document</title>
</head>

<body class="dark:bg-gray-600">

    <?php
    include "./navegacionGestor.php";
    ?>
    <!-- Aqui va todo el contenido editable -->
    <div class="p-3 md:ml-64 min-h-screen dark:bg-gradient-to-br dark:from-gray-700 dark:to-gray-900 flex justify-center items-center relative">
        <button
            onclick="volverAtrasTarea()"
            class="cursor-pointer absolute top-6 left-6 z-20 p-2 rounded-full bg-zinc-800 hover:bg-zinc-700 text-blue-400 hover:text-blue-200 shadow transition block hidden lg:block"
            title="Volver atrás" aria-label="Volver atrás">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <div class="w-full max-w-3xl bg-gradient-to-br from-[#232b3a] via-[#2d3650] to-[#232b3a] p-8 rounded-2xl shadow-2xl border-2 border-blue-400/20 relative transition-all duration-500">
            <?php
            if (isset($_POST["id_tarea"])) {
                $id_tarea = $_POST['id_tarea'];
            } elseif (isset($_SESSION["id_tarea"])) {
                $id_tarea = $_SESSION["id_tarea"];
            }

            $mostrarInfoTarea = new selectAllClass;
            $fila = $mostrarInfoTarea->mostrarInfoTarea($id_tarea);

            $ts_creacion = strtotime($fila['creacion_tarea']);
            $dias_activa = floor((time() - $ts_creacion) / 86400);
            ?>

            <div class="flex items-center mb-6">
                <h1 class="text-3xl font-bold text-white break-words whitespace-normal drop-shadow flex-1 overflow-hidden max-w-full"
                    style="-webkit-line-clamp:2; display:-webkit-box; -webkit-box-orient:vertical;"
                    title="<?= $fila['titulo_tarea'] ?>">
                    <?= $fila['titulo_tarea'] ?>
                </h1>
                <button
                    onclick="volverAtrasTarea()"
                    class="cursor-pointer lg:hidden ml-4 p-2 rounded-full bg-zinc-800 hover:bg-zinc-700 text-blue-400 hover:text-blue-200 shadow transition"
                    title="Volver atrás" aria-label="Volver atrás">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <div class="relative mb-6">
                <div id="contenedor_descripcion" class="relative overflow-hidden transition-all duration-500 ease-in-out max-h-[5.6rem]">
                    <p id="texto_descripcion" class="text-zinc-200 whitespace-normal break-words leading-relaxed">
                        <?= $fila['descripcion_tarea'] ?>
                    </p>
                    <div id="degradado_descripcion" class="absolute bottom-0 left-0 w-full h-8 bg-gradient-to-t from-[#232b3a]/80 to-transparent pointer-events-none transition-all duration-300 ease-in-out"></div>
                </div>
                <button id="boton_descripcion"
                    class="mt-3 inline-block px-4 py-2 text-sm font-medium bg-[#232b3a] text-blue-300 rounded-lg hover:bg-[#2d3650] transition"
                    onclick="alternarDescripcion()">
                    Mostrar más
                </button>
            </div>

            <div class="flex flex-wrap justify-center gap-3">
                <span class="px-4 py-1 rounded-full text-sm font-medium
        <?= $fila['prioridad_tarea'] === 'alta' ? 'bg-red-500 text-white' : ($fila['prioridad_tarea'] === 'media' ? 'bg-yellow-400 text-white' : 'bg-green-500 text-white') ?>">
                    Prioridad: <?= $fila['prioridad_tarea'] ?>
                </span>
                <span class="px-4 py-1 rounded-full text-sm font-medium
        <?= $fila['estado_tarea'] === 'finalizada' ? 'bg-green-400 text-white' : ($fila['estado_tarea'] === 'progresando' ? 'bg-violet-400 text-white' : 'bg-amber-400 text-white') ?>">
                    Estado: <?= $fila['estado_tarea'] ?>
                </span>
                <span class="px-4 py-1 rounded-full text-sm bg-zinc-700 text-white">
                    Antigüedad: <?= $dias_activa ?> días
                </span>
                <span class="px-4 py-1 rounded-full text-sm bg-zinc-800 text-zinc-300">
                    Creado el: <?= date('d/m/Y', $ts_creacion) ?>
                </span>
            </div>
            <?php
            $mostrarInfoArchivoTareaObjeto = new selectAllClass;
            $mostrarInfoArchivoTarea = $mostrarInfoArchivoTareaObjeto->mostrarArchivoTarea($id_tarea);
            if (mysqli_num_rows($mostrarInfoArchivoTarea) > 0) {
            ?>
                <div class="mt-6">
                    <h2 class="text-white text-lg font-semibold mb-3 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a2 2 0 10-2.828-2.828z" />
                        </svg>
                        Archivos adjuntos
                    </h2>

                    <div id="archivosAdjuntos" class="flex flex-wrap justify-center items-center gap-4">
                        <?php
                        $contador = 0;
                        while ($fila2 = mysqli_fetch_assoc($mostrarInfoArchivoTarea)) {
                            $contador++;
                            // Oculta a partir del tercero
                            $claseOculta = $contador > 2 ? 'hidden archivo-extra' : '';
                        ?>
                            <div class="flex items-center justify-between bg-gradient-to-br from-zinc-800 via-zinc-900 to-blue-900/80 text-white p-4 rounded-xl shadow-lg w-full sm:w-1/2 lg:w-1/3 border border-blue-700/30 transition-transform duration-300 hover:scale-105 hover:shadow-2xl <?php echo $claseOculta; ?>">
                                <div class="flex items-center space-x-3 overflow-hidden">
                                    <svg class="w-7 h-7 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V7.414a2 2 0 00-.586-1.414l-4.414-4.414A2 2 0 0012.586 1H4zm8 1.414L16.586 7H13a1 1 0 01-1-1V3.414z" />
                                    </svg>
                                    <span class="text-sm truncate max-w-[140px] font-medium text-blue-200"><?php echo $fila2["nombre_archivoTarea"] ?></span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="../archive/tareas/<?php echo $fila2["nombre_archivoTarea"] ?>" target="_blank"
                                        class="mx-2 px-3 py-1.5 text-sm font-medium border border-blue-400 text-blue-400 rounded-lg bg-zinc-900 hover:bg-blue-500 hover:text-white transition duration-200 shadow-sm hover:shadow-md">
                                        Ver
                                    </a>
                                    <form action="procesar/eliminar_archivo.php" method="POST" class="inline">
                                        <input type="hidden" name="id_archivo" value="<?php echo $fila2['id_archivoTarea'] ?>">
                                        <input type="hidden" name="id_tarea" value="<?php echo $id_tarea ?>">
                                        <button type="submit"
                                            class="text-red-400 hover:text-red-600 text-lg font-bold transition duration-200 bg-transparent border-0 pt-2 m-0"
                                            title="Eliminar archivo">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($contador > 2): ?>
                        <div class="flex justify-center mt-4 gap-3">
                            <button id="mostrarMasArchivos" onclick="mostrarMasArchivos()"
                                class="text-sm font-semibold text-zinc-100 px-4 py-2 rounded-lg
            bg-gradient-to-r from-[#232b3a] via-[#2d3650] to-[#232b3a]
            border border-zinc-700 shadow
            hover:bg-[#2d3650] hover:text-blue-300
            transition-all duration-300 ease-in-out relative z-10">
                                <svg class="inline w-5 h-5 mr-1 -mt-1 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m7-7H5" />
                                </svg>
                                Mostrar más archivos
                            </button>
                            <button id="mostrarMenosArchivos" onclick="mostrarMenosArchivos()" style="display:none"
                                class="text-sm font-semibold text-zinc-100 px-4 py-2 rounded-lg
            bg-gradient-to-r from-[#232b3a] via-[#2d3650] to-[#232b3a]
            border border-zinc-700 shadow
            hover:bg-[#2d3650] hover:text-pink-300
            transition-all duration-300 ease-in-out relative z-10">
                                <svg class="inline w-5 h-5 mr-1 -mt-1 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5" />
                                </svg>
                                Mostrar menos archivos
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            <?php
            }
            ?>
            <div class="flex flex-wrap justify-center gap-3 mt-6">
                <a href="#" onclick="event.preventDefault(); abrirModal()"
                    class="text-sm font-semibold text-blue-400 px-4 py-2 rounded-lg
                    bg-transparent border border-[3px] border-transparent
                    bg-gradient-to-r from-blue-400 to-purple-500
                    [background-origin:border-box] [background-clip:padding-box,border-box]
                    transition-all duration-300 ease-in-out
                    hover:-translate-y-0.5 hover:shadow-md
                    relative z-10
                    before:absolute before:inset-0 before:rounded-lg before:bg-zinc-800 before:z-[-1] before:content-['']">
                    Modificar tarea
                </a>


                <form action="procesar/eliminar_tarea.php" method="POST" class="inline">
                    <input type="hidden" name="id_tarea" value="<?= $id_tarea ?>">
                    <button type="submit"
                        class="cursor-pointer text-sm font-semibold text-red-400 px-4 py-2 rounded-lg
                        bg-transparent border border-[3px] border-transparent
                        bg-gradient-to-r from-red-400 to-pink-500
                        [background-origin:border-box] [background-clip:padding-box,border-box]
                        transition-all duration-300 ease-in-out
                        hover:-translate-y-0.5 hover:shadow-md
                        relative z-10
                        before:absolute before:inset-0 before:rounded-lg before:bg-zinc-800 before:z-[-1] before:content-['']">
                        Eliminar tarea
                    </button>
                </form>
                <a href="#" onclick="abrirModalArchivos(event)"
                    class="text-sm font-semibold text-green-400 px-4 py-2 rounded-lg
                    bg-transparent border border-[3px] border-transparent
                    bg-gradient-to-r from-green-400 to-lime-500
                    [background-origin:border-box] [background-clip:padding-box,border-box]
                    transition-all duration-300 ease-in-out
                    hover:-translate-y-0.5 hover:shadow-md
                    relative z-10
                    before:absolute before:inset-0 before:rounded-lg before:bg-zinc-800 before:z-[-1] before:content-['']">
                    Añadir archivos
                </a>

            </div>
        </div>
    </div>
    <!-- Modal Modificar tarea -->
    <div id="modalModificar" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300 hidden">
        <div class="bg-gradient-to-br from-zinc-900 via-zinc-800 to-zinc-900 w-full max-w-lg p-8 rounded-2xl shadow-2xl border border-zinc-700 relative">
            <h2 class="text-2xl font-bold text-white mb-6">Modificar tarea</h2>
            <form action="procesar/modificar_tarea.php" method="POST" class="space-y-5">
                <input type="hidden" name="id_tarea" value="<?= $id_tarea ?>">
                <div>
                    <label class="block text-sm text-zinc-400 mb-1">Título</label>
                    <input type="text" name="titulo_tarea" value="<?= $fila['titulo_tarea'] ?>"
                        class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white placeholder-zinc-400 
                    outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-1">Descripción</label>
                    <textarea name="descripcion_tarea" rows="4"
                        class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white placeholder-zinc-400 
                    outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"><?= $fila['descripcion_tarea'] ?></textarea>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <label class="block text-sm text-zinc-400 mb-1">Prioridad</label>
                        <select name="prioridad_tarea"
                            class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option <?= $fila['prioridad_tarea'] === 'alta' ? 'selected' : '' ?>>Alta</option>
                            <option <?= $fila['prioridad_tarea'] === 'media' ? 'selected' : '' ?>>Media</option>
                            <option <?= $fila['prioridad_tarea'] === 'baja' ? 'selected' : '' ?>>Baja</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm text-zinc-400 mb-1">Estado</label>
                        <select name="estado_tarea"
                            class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option <?= $fila['estado_tarea'] === 'finalizada' ? 'selected' : '' ?>>Finalizada</option>
                            <option <?= $fila['estado_tarea'] === 'progresando' ? 'selected' : '' ?>>Progresando</option>
                            <option <?= $fila['estado_tarea'] === 'suspendida' ? 'selected' : '' ?>>Suspendida</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-4 pt-4">
                    <button type="button" onclick="cerrarModal()"
                        class="px-4 py-2 rounded-lg bg-zinc-600 text-white hover:bg-zinc-500 transition duration-200">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 text-white hover:from-purple-500 hover:to-blue-500 transition duration-200">
                        Guardar cambios
                    </button>
                </div>
                <!-- Botón cerrar (X) -->
                <button type="button" onclick="cerrarModal()"
                    class="absolute top-3 right-4 text-zinc-400 hover:text-white text-2xl font-bold">
                    &times;
                </button>
            </form>
        </div>
    </div>
    <!-- Fin Modal Modificar tarea -->

    <!-- Modal Añadir Archivos -->
    <div id="modalArchivos" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300 hidden">
        <div class="bg-gradient-to-br from-zinc-900 via-zinc-800 to-zinc-900 w-full max-w-md p-6 rounded-2xl shadow-2xl border border-zinc-700 relative text-white">
            <h2 class="text-xl font-bold mb-4">Añadir archivos</h2>
            <form action="procesar/subir_archivos.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <input type="hidden" name="id_tarea" value="<?php echo $id_tarea ?>">
                    <label for="archivo" class="block text-sm mb-2 text-white font-medium">Archivo adjunto de la tarea</label>
                    <!-- Área de subida -->
                    <label for="archivo"
                        class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-zinc-600 rounded-lg cursor-pointer hover:border-zinc-400 transition duration-200 bg-zinc-800/60 backdrop-blur-sm text-zinc-300 text-center px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m5 4v8m0 0l4-4m-4 4l-4-4" />
                        </svg>
                        <p><span class="font-semibold text-white">Haz clic para subir</span> o arrastra un archivo</p>
                        <p class="text-xs mt-1 text-zinc-400">PDF, DOCX, XLSX, PNG, JPG, JPEG</p>
                        <input id="archivo" name="archivo" type="file" class="hidden" accept=".pdf,.docx,.xlsx,.png,.jpg,.jpeg" onchange="mostrarArchivo(this)" />
                    </label>
                    <!-- Vista del archivo seleccionado -->
                    <div id="archivoSeleccionado" class="mt-4 hidden bg-zinc-800/60 border border-zinc-600 rounded-lg px-4 py-2 flex justify-between items-center backdrop-blur-sm">
                        <span id="nombreArchivo" class="text-sm truncate"></span>
                        <button type="button" onclick="eliminarArchivo()"
                            class="text-zinc-400 hover:text-red-400 text-lg font-bold ml-4">
                            &times;
                        </button>
                    </div>
                    <p id="errorArchivo" class="mt-2 text-red-500 text-sm hidden">
                        Solo se permiten archivos PDF, DOCX, XLSX, PNG , JPG, JPEG.
                    </p>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="cerrarModalArchivos()"
                        class="px-4 py-2 bg-zinc-700/70 hover:bg-zinc-600 text-white rounded-lg">
                        Cancelar
                    </button>
                    <button id="btnSubirArchivo" type="submit" disabled
                        class="px-4 py-2 bg-gradient-to-r from-purple-500 to-blue-500 text-white rounded-lg opacity-50 cursor-not-allowed transition-all duration-200">
                        Subir archivo
                    </button>
                </div>
            </form>
            <!-- Botón cerrar (X) -->
            <button onclick="cerrarModalArchivos()"
                class="absolute top-3 right-4 text-zinc-400 hover:text-white text-2xl font-bold">
                &times;
            </button>
        </div>
    </div>
    <!-- Fin Modal Añadir Archivos -->

    <script>
        function alternarDescripcion() {
            const contenedor = document.getElementById('contenedor_descripcion')
            const degradado = document.getElementById('degradado_descripcion')
            const boton = document.getElementById('boton_descripcion')

            contenedor.classList.toggle('max-h-[5.6rem]')
            degradado.classList.toggle('hidden')

            if (boton.textContent === 'Mostrar más') {
                boton.textContent = 'Mostrar menos'
            } else {
                boton.textContent = 'Mostrar más'
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            const contenedor = document.getElementById('contenedor_descripcion')
            const texto = document.getElementById('texto_descripcion')
            const boton = document.getElementById('boton_descripcion')
            const degradado = document.getElementById('degradado_descripcion')

            if (texto.scrollHeight <= contenedor.clientHeight + 2) {
                boton.classList.remove('inline-block')
                boton.classList.add('hidden')
                degradado.classList.add('hidden')
            }
        })
    </script>
    <script>
        function abrirModal() {
            document.getElementById('modalModificar').classList.remove('hidden')
        }

        function cerrarModal() {
            document.getElementById('modalModificar').classList.add('hidden')
        }

        function abrirModalArchivos(event) {
            event.preventDefault();
            document.getElementById('modalArchivos').classList.remove('hidden');
        }

        function cerrarModalArchivos() {
            document.getElementById('modalArchivos').classList.add('hidden');
        }
    </script>
    <script>
        const tiposPermitidos = ['pdf', 'docx', 'xlsx', 'png', 'jpg', 'jpeg'];

        function mostrarArchivo(input) {
            const archivoSeleccionado = document.getElementById("archivoSeleccionado");
            const nombreArchivo = document.getElementById("nombreArchivo");
            const botonSubir = document.getElementById("btnSubirArchivo");
            const errorArchivo = document.getElementById("errorArchivo");

            if (input.files.length > 0) {
                const archivo = input.files[0];
                const extension = archivo.name.split('.').pop().toLowerCase();

                if (!tiposPermitidos.includes(extension)) {
                    // Mostrar error
                    errorArchivo.classList.remove("hidden");
                    archivoSeleccionado.classList.add("hidden");
                    botonSubir.disabled = true;
                    botonSubir.classList.add("opacity-50", "cursor-not-allowed");
                    input.value = ""; // Limpiar input
                    return;
                }

                // Archivo válido
                errorArchivo.classList.add("hidden");
                nombreArchivo.textContent = archivo.name;
                archivoSeleccionado.classList.remove("hidden");

                botonSubir.disabled = false;
                botonSubir.classList.remove("opacity-50", "cursor-not-allowed");
            } else {
                eliminarArchivo();
            }
        }

        function eliminarArchivo() {
            const input = document.getElementById("archivo");
            const archivoSeleccionado = document.getElementById("archivoSeleccionado");
            const botonSubir = document.getElementById("btnSubirArchivo");
            const errorArchivo = document.getElementById("errorArchivo");

            input.value = "";
            archivoSeleccionado.classList.add("hidden");
            errorArchivo.classList.add("hidden");

            botonSubir.disabled = true;
            botonSubir.classList.add("opacity-50", "cursor-not-allowed");
        }
    </script>
    <script>
        function mostrarMasArchivos() {
            document.querySelectorAll('.archivo-extra').forEach(el => el.classList.remove('hidden'));
            document.getElementById('mostrarMasArchivos').style.display = 'none';
            document.getElementById('mostrarMenosArchivos').style.display = 'inline-block';
        }

        function mostrarMenosArchivos() {
            document.querySelectorAll('.archivo-extra').forEach(el => el.classList.add('hidden'));
            document.getElementById('mostrarMasArchivos').style.display = 'inline-block';
            document.getElementById('mostrarMenosArchivos').style.display = 'none';
        }
    </script>
    <script>
        function volverAtrasTarea() {
            const ref = document.referrer;
            if (
                ref.includes('modificar_tarea.php') ||
                ref.includes('eliminar_tarea.php') ||
                ref.includes('eliminar_archivo.php') ||
                ref.includes('subir_archivos.php') ||
                ref.includes('crearTarea1.php') ||
                ref.includes('masInformacionTareas.php')
            ) {
                window.location.href = 'tareas.php';
            } else {
                window.history.back();
            }
        }
    </script>


    <?php
    include "../../tools/flowbitejs.html";
    ?>
</body>

</html>