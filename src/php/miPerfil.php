<?php
require_once "../includes/sessions/verificarJS.php";
require_once "../includes/sessions/sesionInicio.php";
require_once "../database/conexion.php";
require_once "../includes/classes/selectAll.php";
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
    <title>Mi perfil</title>
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

<body class="dark:bg-gray-600">

    <?php
    include "./navegacionGestor.php";
    ?>
    <!-- Aquí va todo el contenido editable -->
    <div class="p-3 md:ml-64 dark:bg-gray-600 min-h-screen flex items-center justify-center">
        <?php
        $objetoInfoUsuario = new selectAllClass;
        $infoUsuario = $objetoInfoUsuario->informacionUsuario($_SESSION["id"]);
        ?>
        <div class="w-full max-w-6xl bg-gray-800 rounded-2xl shadow-2xl p-8 md:p-12 text-white">
            <div class="flex flex-col xl:flex-row items-center gap-10">
                <!-- Perfil -->
                <div class="flex flex-col items-center text-center w-full xl:w-1/3">
                    <div class="w-40 h-40 my-5 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 p-1 shadow-md">
                        <?php
                        if ($infoUsuario["avatar_usuario"] == null) {
                        ?>
                            <img src="../../assets/img/usuarios/avatarNULL.png" alt="Avatar" class="w-full h-full rounded-full bg-white p-1" />
                        <?php
                        } else {
                        ?>
                            <img src="../../assets/img/usuarios/<?php echo $infoUsuario["avatar_usuario"] ?>" alt="Avatar" class="w-full h-full rounded-full bg-white p-1" />
                        <?php
                        }
                        ?>
                    </div>
                    <h2 class="text-2xl font-bold my-2 overflow-hidden w-full"><?php echo $infoUsuario["nombre_usuario"] ?></h2>
                    <p class="text-gray-300 text-xl my-2 overflow-hidden w-full"><?php echo $infoUsuario["email_usuario"] ?></p>
                    <p class="text-md text-gray-400 my-2">Creado el: <?php echo $infoUsuario["creacion_usuario"] ?></p>
                    <div class="flex flex-col xl:flex-row gap-3 w-full max-w-90">
                        <button type="button" onclick="abrirModalCambiarPassword()" class="px-5 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white transition w-full">
                            Cambiar contraseña
                        </button>
                        <form action="procesar/eliminar_cuenta.php" method="post" class="w-full">
                            <input type="hidden" name="id_usuario" value="<?php echo $infoUsuario["id_usuario"] ?>">
                            <button type="submit" class="flex justify-center items-center px-5 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition text-center w-full h-full">
                                Eliminar cuenta
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Información editable -->
                <form method="POST" action="procesar/modificar_usuario.php" class="w-full xl:w-2/3 flex flex-col gap-6" enctype="multipart/form-data">
                    <input type="hidden" name="id_usuario" value="<?php echo $infoUsuario["id_usuario"] ?>">
                    <div class="my-1.5">
                        <label id="nombreLabel" for="nombre" class="block text-sm text-gray-300 mb-1">Nombre usuario</label>
                        <input type="text" name="nombre" id="nombre" class="w-full p-3 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $infoUsuario["nombre_usuario"] ?>" />
                    </div>
                    <div class="my-1.5">
                        <label class="block text-sm text-gray-300 mb-1">Correo electrónico</label>
                        <input type="email" disabled class="w-full p-3 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?php echo $infoUsuario["email_usuario"] ?>" />
                    </div>
                    <div class="my-1.5">
                        <label id="avatarLabel" for="avatar" class="block text-sm text-gray-300 mb-1">Cambiar avatar</label>
                        <input
                            type="file"
                            name="avatar"
                            id="avatar"
                            accept=".jpg,.jpeg,.png"
                            class="w-full p-2 pl-5 rounded-lg bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 
                            file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold 
                            file:bg-gray-800 file:text-gray-200 hover:file:bg-gray-700 transition" />
                    </div>
                    <div class="my-1.5">
                        <label class="block text-sm text-gray-300 mb-1">Fecha de creación</label>
                        <input type="text" disabled class="w-full p-3 rounded-lg bg-gray-700 text-white" value="<?php echo $infoUsuario["creacion_usuario"] ?>" />
                    </div>
                    <button type="submit" id="botonGuardar" class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-xl hover:from-blue-600 hover:to-blue-800 transition text-lg font-semibold">
                        Guardar cambios
                    </button>
                </form>
            </div>
        </div>
        <?php
        include "../includes/functions/chatbot.php";
        ?>
    </div>
    <!-- Modal Cambiar Contraseña -->
    <div id="modalCambiarPassword" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-all duration-300 hidden">
        <div class="bg-gradient-to-br from-zinc-900 via-zinc-800 to-zinc-900 w-full max-w-lg p-8 rounded-2xl shadow-2xl border border-zinc-700 relative">
            <h2 class="text-2xl font-bold text-white mb-6">Modificar contraseña</h2>
            <form action="procesar/cambiar_password.php" method="POST" class="space-y-5" id="formCambiarPassword">
                <input type="hidden" name="id_usuario" value="<?php echo $infoUsuario['id_usuario']; ?>">
                <div>
                    <label id="labelNuevaPassword" for="nueva_password" class="block text-sm text-zinc-400 mb-1">Nueva contraseña</label>
                    <input type="password" name="nueva_password" id="nueva_password"
                        class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white placeholder-zinc-400 
                    outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" required>
                </div>
                <div>
                    <label id="labelRepetirPassword" for="repetir_password" class="block text-sm text-zinc-400 mb-1">Repetir contraseña</label>
                    <input type="password" name="repetir_password" id="repetir_password"
                        class="w-full px-4 py-2 rounded-lg bg-zinc-700 text-white placeholder-zinc-400 
                    outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" required>
                </div>
                <div class="flex justify-end gap-4 pt-4">
                    <button type="button" onclick="cerrarModalCambiarPassword()"
                        class="px-4 py-2 rounded-lg bg-zinc-600 text-white hover:bg-zinc-500 transition duration-200">
                        Cancelar
                    </button>
                    <button type="submit" id="botonCambiarPassword"
                        class="px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 text-white hover:from-purple-500 hover:to-blue-500 transition duration-200" disabled>
                        Guardar contraseña
                    </button>
                </div>
                <!-- Botón cerrar (X) -->
                <button type="button" onclick="cerrarModalCambiarPassword()"
                    class="absolute top-3 right-4 text-zinc-400 hover:text-white text-2xl font-bold">
                    &times;
                </button>
            </form>
        </div>
    </div>



    <?php
    include "../../tools/flowbitejs.html";
    ?>
    <script>
        const botonGuardar = document.querySelector("#botonGuardar");

        const username = document.querySelector("#nombre");
        const usernameLaberl = document.querySelector("#nombreLabel");

        const avatar = document.querySelector("#avatar");
        const avatarLabel = document.querySelector("#avatarLabel");

        botonGuardar.setAttribute("disabled", true);

        let verificadoUsername = true;

        const valorOriginalNombre = username.value;

        username.addEventListener("input", () => {
            const caracteresEspeciales = /[!@#$%^&*()/,.?":{}|<>]/;
            const soloLetrasNumeros = /^[a-zA-Z0-9]+$/;

            // Si el campo está vacío, inválido
            if (username.value.length === 0) {
                usernameLaberl.innerHTML = "Nombre de usuario";
                usernameLaberl.classList.remove("erroneo");
                usernameLaberl.classList.remove("correcto");
                verificadoUsername = false;
                // Si el valor es igual al original, lo consideramos válido
            } else if (username.value === valorOriginalNombre) {
                usernameLaberl.innerHTML = "Nombre de usuario";
                usernameLaberl.classList.remove("erroneo");
                usernameLaberl.classList.add("correcto");
                verificadoUsername = true;
            } else if (username.value.length < 5) {
                usernameLaberl.innerHTML = "El usuario debe tener al menos 5 caracteres";
                usernameLaberl.classList.add("erroneo");
                usernameLaberl.classList.remove("correcto");
                verificadoUsername = false;
            } else if (username.value.length > 20) {
                usernameLaberl.innerHTML = "El usuario no puede tener mas de 20 caracteres";
                usernameLaberl.classList.add("erroneo");
                usernameLaberl.classList.remove("correcto");
                verificadoUsername = false;
            } else if (caracteresEspeciales.test(username.value)) {
                usernameLaberl.innerHTML = "El usuario no puede contener caracteres especiales";
                usernameLaberl.classList.add("erroneo");
                usernameLaberl.classList.remove("correcto");
                verificadoUsername = false;
            } else if (!soloLetrasNumeros.test(username.value)) {
                usernameLaberl.innerHTML = "El usuario solo puede contener letras y números";
                usernameLaberl.classList.add("erroneo");
                usernameLaberl.classList.remove("correcto");
                verificadoUsername = false;
            } else {
                usernameLaberl.innerHTML = "Nombre de usuario";
                usernameLaberl.classList.remove("erroneo");
                usernameLaberl.classList.add("correcto");
                verificadoUsername = true;
            }
            enviarFormulario();
        });

        let verificadoAvatar = true;

        if (avatar && avatarLabel) {
            avatar.addEventListener("change", () => {
                if (avatar.files.length === 0) {
                    avatarLabel.innerHTML = "Sube tu avatar";
                    avatarLabel.classList.remove("erroneo");
                    avatarLabel.classList.remove("correcto");
                    verificadoAvatar = true;
                    enviarFormulario();
                    return;
                }
                const file = avatar.files[0];
                const validTypes = ["image/jpeg", "image/png", "image/jpg"];
                if (!validTypes.includes(file.type)) {
                    avatarLabel.innerHTML = "Solo se permiten imágenes JPG, JPEG o PNG";
                    avatarLabel.classList.add("erroneo");
                    avatarLabel.classList.remove("correcto");
                    verificadoAvatar = false;
                } else {
                    avatarLabel.innerHTML = "Correcto";
                    avatarLabel.classList.remove("erroneo");
                    avatarLabel.classList.add("correcto");
                    verificadoAvatar = true;
                }
                enviarFormulario();
            });
        }

        function enviarFormulario() {
            // Si ambos están vacíos, no se puede enviar
            const nombreVacio = username.value.trim() === "";
            const avatarVacio = !avatar.files.length;

            // Si ambos vacíos, deshabilita
            if (nombreVacio && avatarVacio) {
                botonGuardar.setAttribute("disabled", true);
                return;
            }

            // Si alguno tiene error, deshabilita
            if (!verificadoUsername || !verificadoAvatar) {
                botonGuardar.setAttribute("disabled", true);
                return;
            }

            // Si al menos uno es válido y ninguno tiene error, habilita
            botonGuardar.removeAttribute("disabled");
        }

        // Abrir modal
        function abrirModalCambiarPassword() {
            document.getElementById('modalCambiarPassword').classList.remove('hidden');
        }

        function cerrarModalCambiarPassword() {
            document.getElementById('modalCambiarPassword').classList.add('hidden');
        }

        // Validación de contraseña en el modal
        const nuevaPassword = document.getElementById("nueva_password");
        const repetirPassword = document.getElementById("repetir_password");
        const labelNuevaPassword = document.getElementById("labelNuevaPassword");
        const labelRepetirPassword = document.getElementById("labelRepetirPassword");
        const botonCambiarPassword = document.getElementById("botonCambiarPassword");

        botonCambiarPassword.setAttribute("disabled", true);

        let validNuevaPassword = false;
        let validRepetirPassword = false;

        nuevaPassword.addEventListener("input", () => {
            const caracteresEspeciales = /[!@#$%^&*()/,.?":{}|<>]/;
            const mayusculas = /[A-Z]/;
            const minusculas = /[a-z]/;
            const numeros = /[0-9]/;

            if (nuevaPassword.value.length === 0) {
                labelNuevaPassword.innerHTML = "Nueva contraseña";
                labelNuevaPassword.classList.remove("erroneo", "correcto");
                validNuevaPassword = false;
            } else if (nuevaPassword.value.length < 8) {
                labelNuevaPassword.innerHTML = "Minimo 8 caracteres";
                labelNuevaPassword.classList.add("erroneo");
                labelNuevaPassword.classList.remove("correcto");
                validNuevaPassword = false;
            } else if (!caracteresEspeciales.test(nuevaPassword.value)) {
                labelNuevaPassword.innerHTML = "Usa caracteres especiales";
                labelNuevaPassword.classList.add("erroneo");
                labelNuevaPassword.classList.remove("correcto");
                validNuevaPassword = false;
            } else if (!mayusculas.test(nuevaPassword.value)) {
                labelNuevaPassword.innerHTML = "Usa mayúsculas";
                labelNuevaPassword.classList.add("erroneo");
                labelNuevaPassword.classList.remove("correcto");
                validNuevaPassword = false;
            } else if (!minusculas.test(nuevaPassword.value)) {
                labelNuevaPassword.innerHTML = "Usa minúsculas";
                labelNuevaPassword.classList.add("erroneo");
                labelNuevaPassword.classList.remove("correcto");
                validNuevaPassword = false;
            } else if (!numeros.test(nuevaPassword.value)) {
                labelNuevaPassword.innerHTML = "Usa números";
                labelNuevaPassword.classList.add("erroneo");
                labelNuevaPassword.classList.remove("correcto");
                validNuevaPassword = false;
            } else {
                labelNuevaPassword.innerHTML = "Correcta";
                labelNuevaPassword.classList.remove("erroneo");
                labelNuevaPassword.classList.add("correcto");
                validNuevaPassword = true;
            }
            validarBotonCambiarPassword();
        });

        repetirPassword.addEventListener("input", () => {
            if (repetirPassword.value.length === 0) {
                labelRepetirPassword.innerHTML = "Repetir contraseña";
                labelRepetirPassword.classList.remove("erroneo", "correcto");
                validRepetirPassword = false;
            } else if (repetirPassword.value !== nuevaPassword.value) {
                labelRepetirPassword.innerHTML = "No coinciden";
                labelRepetirPassword.classList.add("erroneo");
                labelRepetirPassword.classList.remove("correcto");
                validRepetirPassword = false;
            } else {
                labelRepetirPassword.innerHTML = "Correcta";
                labelRepetirPassword.classList.remove("erroneo");
                labelRepetirPassword.classList.add("correcto");
                validRepetirPassword = true;
            }
            validarBotonCambiarPassword();
        });

        function validarBotonCambiarPassword() {
            if (validNuevaPassword && validRepetirPassword) {
                botonCambiarPassword.removeAttribute("disabled");
            } else {
                botonCambiarPassword.setAttribute("disabled", true);
            }
        }
    </script>
</body>

</html>