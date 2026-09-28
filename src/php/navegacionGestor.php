<?php
require_once "../database/conexion.php";
require_once "../includes/classes/selectAll.php";

$mostrarTareasUsuario = new selectAllClass;
$mostrarTareasUsuario = $mostrarTareasUsuario->cantidadTareasUsuario($_SESSION["id"]);

$mostrarProyectosUsuario = new selectAllClass;
$mostrarProyectosUsuario = $mostrarProyectosUsuario->cantidadProyectosUsuario($_SESSION["id"]);

$mostrarNotificacionesUsuario = new selectAllClass;
$mostrarNotificacionesUsuario = $mostrarNotificacionesUsuario->cantidadNotificacionesUsuario($_SESSION["id"]);
?>
<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 mb-1 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-600 dark:focus:ring-gray-500">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="#1a1a1a" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full md:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <a href="gestor.php" class="flex items-center ps-2.5 mb-5">
            <img src="https://cdmdavidro.es/assets/favicon/FlowManager.png" class="h-6 me-3 sm:h-7" alt="Flowbite Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">FlowManager</span>
        </a>
        <ul class="space-y-2 font-medium">
            <li>
                <a href="gestor.php" class="flex items-center p-4 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M14.06 9.94L12 9l2.06-.94L15 6l.94 2.06L18 9l-2.06.94L15 12zM4 14l.94-2.06L7 11l-2.06-.94L4 8l-.94 2.06L1 11l2.06.94zm4.5-5l1.09-2.41L12 5.5L9.59 4.41L8.5 2L7.41 4.41L5 5.5l2.41 1.09zm-4 11.5l6-6.01l4 4L23 8.93l-1.41-1.41l-7.09 7.97l-4-4L3 19z" />
                    </svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="tareas.php" class="flex items-center p-4 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M9 21H5c-1.1 0-2-.9-2-2V5c0-1.1.9-2 2-2h4c1.1 0 2 .9 2 2v14c0 1.1-.9 2-2 2m6 0h4c1.1 0 2-.9 2-2v-5c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v5c0 1.1.9 2 2 2m6-13V5c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v3c0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Tareas</span>
                    <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300"><?php echo $mostrarTareasUsuario ?></span>
                </a>
            </li>
            <li>
                <a href="proyectos.php" class="flex items-center p-4 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m3.61 6.34c1.07 0 1.93.86 1.93 1.93s-.86 1.93-1.93 1.93s-1.93-.86-1.93-1.93c-.01-1.07.86-1.93 1.93-1.93m-6-1.58c1.3 0 2.36 1.06 2.36 2.36s-1.06 2.36-2.36 2.36s-2.36-1.06-2.36-2.36c0-1.31 1.05-2.36 2.36-2.36m0 9.13v3.75c-2.4-.75-4.3-2.6-5.14-4.96c1.05-1.12 3.67-1.69 5.14-1.69c.53 0 1.2.08 1.9.22c-1.64.87-1.9 2.02-1.9 2.68M12 20c-.27 0-.53-.01-.79-.04v-4.07c0-1.42 2.94-2.13 4.4-2.13c1.07 0 2.92.39 3.84 1.15C18.28 17.88 15.39 20 12 20" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Proyectos</span>
                    <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300"><?php echo $mostrarProyectosUsuario ?></span>
                </a>
            </li>
            <li>
                <a href="notificaciones.php" class="flex items-center p-4 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M18 16v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.68-1.5-1.51-1.5S10.5 3.17 10.5 4v.68C7.63 5.36 6 7.92 6 11v5l-1.3 1.29c-.63.63-.19 1.71.7 1.71h13.17c.89 0 1.34-1.08.71-1.71zm-6.01 6c1.1 0 2-.9 2-2h-4a2 2 0 0 0 2 2M6.77 4.73c.42-.38.43-1.03.03-1.43a1 1 0 0 0-1.39-.02a10.42 10.42 0 0 0-3.27 6.06c-.09.61.38 1.16 1 1.16c.48 0 .9-.35.98-.83a8.44 8.44 0 0 1 2.65-4.94M18.6 3.28c-.4-.37-1.02-.36-1.4.02c-.4.4-.38 1.04.03 1.42c1.38 1.27 2.35 3 2.65 4.94c.07.48.49.83.98.83c.61 0 1.09-.55.99-1.16c-.38-2.37-1.55-4.48-3.25-6.05" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Notificaciones</span>
                    <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300"><?php echo $mostrarNotificacionesUsuario ?></span>
                </a>
            </li>
            <li>
                <a href="../includes/sessions/cerrarSesion.php" class="flex items-center p-4 text-red-500 rounded-lg dark:text-red hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M16 17v1a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v1h-2V6H7v12h7v-1h2ZM19.71 11.29l-3-3a1 1 0 0 0-1.42 1.42L16.59 11H11a1 1 0 0 0 0 2h5.59l-1.3 1.29a1 1 0 1 0 1.42 1.42l3-3a1 1 0 0 0 0-1.42Z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Cerrar Sesion</span>
                </a>
            </li>
        </ul>
        <a href="miPerfil.php" class="absolute bottom-0 left-0 w-full p-4 bg-gray-100 dark:bg-gray-800">
            <div class="flex items-center space-x-4">
                <?php
                if ($_SESSION["avatar"] === null) {
                ?>
                    <img class="w-10 h-10 rounded-full" src="../../assets/img/usuarios/avatarNULL.png" alt="Foto de usuario">
                <?php
                } else {
                ?>
                    <img class="w-10 h-10 rounded-full" src="https://cdmdavidro.es/assets/img/usuarios/<?php echo $_SESSION["avatar"] ?>" alt="Foto de usuario">
                <?php
                }
                ?>

                <div class="font-medium dark:text-white">
                    <div class="truncate max-w-[120px] block">
                        <?php
                        // Mostrar el nombre del usuario registrado
                        echo isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Usuario';
                        ?>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-[150px] block">
                        <?php
                        // Mostrar el correo del usuario registrado
                        echo isset($_SESSION['email']) ? $_SESSION['email'] : 'correo@ejemplo.com';
                        ?>
                    </div>
                </div>
            </div>
        </a>
    </div>
</aside>