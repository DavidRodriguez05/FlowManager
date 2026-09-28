<?php
class selectAllClass
{
    public function selectAll($tabla)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "SELECT * FROM $tabla";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
    public function selectAllWhere($tabla, $where)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "SELECT * FROM $tabla WHERE $where";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
    public function selectAllLimit($tabla, $limit)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "SELECT * FROM $tabla LIMIT $limit";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
    public function selectAllLimitWhere($tabla, $limit, $where)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "SELECT * FROM $tabla WHERE $where LIMIT $limit";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
    public function selectTaskCountByState($tabla)
    {
        $c = new conexion();
        $conexion = $c->conectar();

        // Consulta para contar las tareas agrupadas por estado
        $sql = "
        SELECT 
            estado_tarea AS estado, 
            COUNT(*) AS cantidad 
        FROM $tabla 
        GROUP BY estado_tarea
        ";
        $resultado = mysqli_query($conexion, $sql);

        // Verificar si la consulta tuvo éxito
        if (!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }

        $datos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        // Si no hay resultados, devolver un arreglo con valores predeterminados
        if (empty($datos)) {
            return [['estado' => 'Sin estado', 'cantidad' => 0]];
        }

        return $datos;
    }
    public function selectAllTaskCount($tabla)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "SELECT COUNT(*) AS cantidad FROM $tabla";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
    public function selectAllProjectCount($tabla)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "SELECT COUNT(*) AS cantidad FROM $tabla";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
    public function selectAllProjectDataLast($tabla)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "SELECT nombre_proyecto, estado_proyecto, creacion_proyecto FROM $tabla ORDER BY creacion_proyecto DESC LIMIT 1";
        $resultado = mysqli_query($conexion, $sql);

        // Verificar si la consulta tuvo éxito
        if (!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }

        $datos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        // Si no hay resultados, devolver un arreglo con valores predeterminados
        if (empty($datos)) {
            return [[
                'nombre_proyecto' => 'Sin proyecto',
                'estado_proyecto' => 'Sin proyecto',
                'creacion_proyecto' => 'Sin proyecto'
            ]];
        }

        return $datos;
    }
    public function selectProjectStatusCount($tabla, $estadoColumn)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "SELECT $estadoColumn AS estado, COUNT(*) AS cantidad FROM $tabla GROUP BY $estadoColumn";
        $resultado = mysqli_query($conexion, $sql);

        // Verificar si la consulta tuvo éxito
        if (!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }

        $datos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        // Si no hay resultados, devolver un arreglo con cantidad: 0
        if (empty($datos)) {
            return [['estado' => null, 'cantidad' => 0]];
        }

        return $datos;
    }
    public function selectTasksByWeek($tabla, $fechaColumn)
    {
        $c = new conexion();
        $conexion = $c->conectar();

        // Consulta para obtener las tareas agrupadas por semana
        $sql = "
            SELECT 
                WEEK($fechaColumn, 1) AS semana, 
                COUNT(*) AS cantidad 
            FROM $tabla 
            WHERE MONTH($fechaColumn) = MONTH(CURDATE()) 
            AND YEAR($fechaColumn) = YEAR(CURDATE())
            GROUP BY WEEK($fechaColumn, 1)
            ORDER BY semana ASC
        ";
        $resultado = mysqli_query($conexion, $sql);
        $datos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        // Procesar los datos para incluir todas las semanas del mes
        $semanas = [];
        for ($i = 1; $i <= 4; $i++) { // Asumiendo 4 semanas por mes
            $semanas["semana $i"] = 0; // Inicializar con 0 tareas
        }

        foreach ($datos as $fila) {
            $semanaIndex = (int)$fila['semana'] - (int)date('W', strtotime('first day of this month')) + 1;
            if ($semanaIndex >= 1 && $semanaIndex <= 4) {
                $semanas["semana $semanaIndex"] = (int)$fila['cantidad'];
            }
        }

        // Formatear el resultado como JSON
        $resultadoFinal = [];
        foreach ($semanas as $semana => $cantidad) {
            $resultadoFinal[] = [
                "semana" => $semana,
                "tareas" => $cantidad
            ];
        }

        return $resultadoFinal;
    }
    public function selectNewestTasks($tabla, $fechaColumn, $limit = 3)
    {
        $c = new conexion();
        $conexion = $c->conectar();

        // Consulta para seleccionar las tareas más nuevas con un límite
        $sql = "
            SELECT titulo_tarea, estado_tarea, creacion_tarea
            FROM $tabla 
            ORDER BY $fechaColumn DESC 
            LIMIT $limit
        ";
        $resultado = mysqli_query($conexion, $sql);

        // Verificar si la consulta tuvo éxito
        if (!$resultado) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }

        $datos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        // Si no hay resultados, devolver un arreglo con valores predeterminados
        if (empty($datos)) {
            return [[
                'titulo_tarea' => 'Sin datos',
                'estado_tarea' => 'Desconocido',
                'creacion_tarea' => '0000-00-00'
            ]];
        }

        return $datos;
    }

    public function mostrarTareas($id)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT id_tarea, titulo_tarea, descripcion_tarea, prioridad_tarea, estado_tarea FROM tareas WHERE id_usuario_tareas = $id";
        $resultado = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_array($resultado)) {
            $idTarea = $fila["id_tarea"];
?>
            <div class="flex flex-col items-center lg:items-start bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 px-5 py-4 border border-blue-100 dark:border-gray-600 mb-4">
                <h3 class="text-2xl font-bold text-blue-900 dark:text-white mb-2 max-w-full overflow-hidden"
                    style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; white-space: normal;"
                    title="<?php echo $fila["titulo_tarea"]; ?>">
                    <?php echo $fila["titulo_tarea"]; ?>
                </h3>
                <p class="w-full text-center lg:text-left text-md text-gray-700 dark:text-gray-300 mb-3 truncate">
                    <?php echo $fila["descripcion_tarea"]; ?>
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["prioridad_tarea"] == "alta") {
                        echo "bg-red-500 text-white";
                    } elseif ($fila["prioridad_tarea"] == "media") {
                        echo "bg-amber-400 text-white";
                    } elseif ($fila["prioridad_tarea"] == "baja") {
                        echo "bg-green-500 text-white";
                    }
                    ?>">
                        Prioridad: <?php echo ucfirst($fila["prioridad_tarea"]); ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["estado_tarea"] == "finalizada") {
                        echo "bg-green-400 text-white";
                    } elseif ($fila["estado_tarea"] == "progresando") {
                        echo "bg-violet-400 text-white";
                    } elseif ($fila["estado_tarea"] == "suspendida") {
                        echo "bg-amber-400 text-white";
                    }
                    ?>">
                        Estado: <?php echo ucfirst($fila["estado_tarea"]); ?>
                    </span>
                </div>
                <form action="masInformacionTareas.php" method="POST" class="mt-2 w-full">
                    <input type="hidden" name="id_tarea" value="<?php echo $idTarea; ?>">
                    <button type="submit" class="cursor-pointer inline-block w-full text-center text-white bg-gradient-to-r from-blue-600 via-blue-500 to-blue-700 hover:from-blue-700 hover:to-blue-800 font-bold rounded-lg text-sm px-5 py-2.5 shadow-lg transition">
                        Más información
                    </button>
                </form>
            </div>
        <?php
        }
    }
    public function mostrarTareasTiempo($id)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT id_tarea, titulo_tarea, descripcion_tarea, prioridad_tarea, estado_tarea, creacion_tarea FROM tareas WHERE id_usuario_tareas = $id AND creacion_tarea <= DATE_SUB(CURDATE(), INTERVAL 8 DAY)";
        $resultado = mysqli_query($conexion, $sql);
        ?>

        <?php
        if (mysqli_num_rows($resultado) > 0) { ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 justify-items-center">
                <?php while ($fila = mysqli_fetch_assoc($resultado)) {
                    $idTarea = $fila["id_tarea"];
                    $ts_creacion = strtotime($fila['creacion_tarea']);
                    $dias_activa = floor((time() - $ts_creacion) / 86400);
                ?>
                    <div class="w-full max-w-4xl bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 border border-blue-100 dark:border-gray-600 p-6 flex flex-col gap-6">
                        <div>
                            <h3 class="text-2xl font-bold text-blue-900 dark:text-white mb-2 truncate" title="<?php echo $fila["titulo_tarea"]; ?>">
                                <?php echo $fila["titulo_tarea"]; ?>
                            </h3>
                            <p class="w-full text-md text-gray-700 dark:text-gray-300 mb-3 truncate">
                                <?php echo $fila["descripcion_tarea"]; ?>
                            </p>
                            <div class="flex flex-wrap gap-3 mb-2">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold shadow
                        <?php
                        if ($fila["prioridad_tarea"] == "alta") {
                            echo "bg-red-500 text-white";
                        } elseif ($fila["prioridad_tarea"] == "media") {
                            echo "bg-amber-400 text-white";
                        } elseif ($fila["prioridad_tarea"] == "baja") {
                            echo "bg-green-500 text-white";
                        }
                        ?>">
                                    Prioridad: <?php echo ucfirst($fila["prioridad_tarea"]); ?>
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold shadow
                        <?php
                        if ($fila["estado_tarea"] == "finalizada") {
                            echo "bg-green-400 text-white";
                        } elseif ($fila["estado_tarea"] == "progresando") {
                            echo "bg-violet-400 text-white";
                        } elseif ($fila["estado_tarea"] == "suspendida") {
                            echo "bg-amber-400 text-white";
                        }
                        ?>">
                                    Estado: <?php echo ucfirst($fila["estado_tarea"]); ?>
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold shadow bg-red-500 text-white">⚠️ <?php echo $dias_activa ?> Dias ⚠️</span>
                            </div>
                        </div>
                        <form action=" masInformacionTareas.php" method="POST" class="w-full">
                            <input type="hidden" name="id_tarea" value="<?php echo $idTarea ?>">
                            <button type="submit" class="cursor-pointer flex items-center gap-2 bg-gradient-to-r from-blue-600 via-blue-500 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-lg text-sm px-6 py-2.5 shadow-lg transition duration-300 w-full justify-center">
                                <svg class="w-5 h-5 text-gray-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                                Mostrar más
                            </button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="rounded-2xl shadow p-8 bg-gray-800 text-white flex flex-col items-center">
                <svg class="w-16 h-16 mb-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <p class="text-xl font-semibold text-center">¡No tienes notificaciones nuevas!</p>
                <p class="text-gray-400 mt-2 text-center">Cuando tengas tareas importantes o avisos, aparecerán aquí.</p>
            </div>
        <?php }
    }
    public function mostrarInfoTarea($id_tarea)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT * FROM tareas WHERE id_tarea = $id_tarea";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_assoc($resultado);
    }
    public function mostrarInfoProyecto($id_proyecto)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT * FROM proyectos WHERE id_proyecto = $id_proyecto";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_fetch_assoc($resultado);
    }

    public function mostrarTareasPD($id)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT id_tarea, titulo_tarea, descripcion_tarea, prioridad_tarea, estado_tarea FROM tareas WHERE id_usuario_tareas = $id ORDER BY prioridad_tarea DESC";
        $resultado = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_array($resultado)) {
            $idTarea = $fila["id_tarea"];
        ?>
            <div class="flex flex-col items-center lg:items-start bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 px-5 py-4 border border-blue-100 dark:border-gray-600 mb-4">
		<h3 class="text-2xl font-bold text-blue-900 dark:text-white mb-2 max-w-full overflow-hidden"
                    style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; white-space: normal;"
                    title="<?php echo $fila["titulo_tarea"]; ?>">
                    <?php echo $fila["titulo_tarea"]; ?>
                </h3>                <p class="w-full text-center lg:text-left text-md text-gray-700 dark:text-gray-300 mb-3 truncate">
                    <?php echo $fila["descripcion_tarea"]; ?>
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["prioridad_tarea"] == "alta") {
                        echo "bg-red-500 text-white";
                    } elseif ($fila["prioridad_tarea"] == "media") {
                        echo "bg-amber-400 text-white";
                    } elseif ($fila["prioridad_tarea"] == "baja") {
                        echo "bg-green-500 text-white";
                    }
                    ?>">
                        Prioridad: <?php echo ucfirst($fila["prioridad_tarea"]); ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["estado_tarea"] == "finalizada") {
                        echo "bg-green-400 text-white";
                    } elseif ($fila["estado_tarea"] == "progresando") {
                        echo "bg-violet-400 text-white";
                    } elseif ($fila["estado_tarea"] == "suspendida") {
                        echo "bg-amber-400 text-white";
                    }
                    ?>">
                        Estado: <?php echo ucfirst($fila["estado_tarea"]); ?>
                    </span>
                </div>
                <form action="masInformacionTareas.php" method="POST" class="mt-2 w-full">
                    <input type="hidden" name="id_tarea" value="<?php echo $idTarea; ?>">
                    <button type="submit" class="cursor-pointer inline-block w-full text-center text-white bg-gradient-to-r from-blue-600 via-blue-500 to-blue-700 hover:from-blue-700 hover:to-blue-800 font-bold rounded-lg text-sm px-5 py-2.5 shadow-lg transition">
                        Más información
                    </button>
                </form>
            </div>
        <?php
        }
    }
    public function mostrarTareasPA($id)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT id_tarea, titulo_tarea, descripcion_tarea, prioridad_tarea, estado_tarea FROM tareas WHERE id_usuario_tareas = $id ORDER BY prioridad_tarea ASC";
        $resultado = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_array($resultado)) {
            $idTarea = $fila["id_tarea"];
        ?>
            <div class="flex flex-col items-center lg:items-start bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 px-5 py-4 border border-blue-100 dark:border-gray-600 mb-4">
		<h3 class="text-2xl font-bold text-blue-900 dark:text-white mb-2 max-w-full overflow-hidden"
                    style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; white-space: normal;"
                    title="<?php echo $fila["titulo_tarea"]; ?>">
                    <?php echo $fila["titulo_tarea"]; ?>
                </h3>                <p class="w-full text-center lg:text-left text-md text-gray-700 dark:text-gray-300 mb-3 truncate">
                    <?php echo $fila["descripcion_tarea"]; ?>
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["prioridad_tarea"] == "alta") {
                        echo "bg-red-500 text-white";
                    } elseif ($fila["prioridad_tarea"] == "media") {
                        echo "bg-amber-400 text-white";
                    } elseif ($fila["prioridad_tarea"] == "baja") {
                        echo "bg-green-500 text-white";
                    }
                    ?>">
                        Prioridad: <?php echo ucfirst($fila["prioridad_tarea"]); ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["estado_tarea"] == "finalizada") {
                        echo "bg-green-400 text-white";
                    } elseif ($fila["estado_tarea"] == "progresando") {
                        echo "bg-violet-400 text-white";
                    } elseif ($fila["estado_tarea"] == "suspendida") {
                        echo "bg-amber-400 text-white";
                    }
                    ?>">
                        Estado: <?php echo ucfirst($fila["estado_tarea"]); ?>
                    </span>
                </div>
                <form action="masInformacionTareas.php" method="POST" class="mt-2 w-full">
                    <input type="hidden" name="id_tarea" value="<?php echo $idTarea; ?>">
                    <button type="submit" class="cursor-pointer inline-block w-full text-center text-white bg-gradient-to-r from-blue-600 via-blue-500 to-blue-700 hover:from-blue-700 hover:to-blue-800 font-bold rounded-lg text-sm px-5 py-2.5 shadow-lg transition">
                        Más información
                    </button>
                </form>
            </div>
        <?php
        }
    }
    public function mostrarTareasED($id)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT id_tarea, titulo_tarea, descripcion_tarea, prioridad_tarea, estado_tarea FROM tareas WHERE id_usuario_tareas = $id ORDER BY estado_tarea DESC";
        $resultado = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_array($resultado)) {
            $idTarea = $fila["id_tarea"];
        ?>
            <div class="flex flex-col items-center lg:items-start bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 px-5 py-4 border border-blue-100 dark:border-gray-600 mb-4">
		<h3 class="text-2xl font-bold text-blue-900 dark:text-white mb-2 max-w-full overflow-hidden"
                    style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; white-space: normal;"
                    title="<?php echo $fila["titulo_tarea"]; ?>">
                    <?php echo $fila["titulo_tarea"]; ?>
                </h3>                <p class="w-full text-center lg:text-left text-md text-gray-700 dark:text-gray-300 mb-3 truncate">
                    <?php echo $fila["descripcion_tarea"]; ?>
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["prioridad_tarea"] == "alta") {
                        echo "bg-red-500 text-white";
                    } elseif ($fila["prioridad_tarea"] == "media") {
                        echo "bg-amber-400 text-white";
                    } elseif ($fila["prioridad_tarea"] == "baja") {
                        echo "bg-green-500 text-white";
                    }
                    ?>">
                        Prioridad: <?php echo ucfirst($fila["prioridad_tarea"]); ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["estado_tarea"] == "finalizada") {
                        echo "bg-green-400 text-white";
                    } elseif ($fila["estado_tarea"] == "progresando") {
                        echo "bg-violet-400 text-white";
                    } elseif ($fila["estado_tarea"] == "suspendida") {
                        echo "bg-amber-400 text-white";
                    }
                    ?>">
                        Estado: <?php echo ucfirst($fila["estado_tarea"]); ?>
                    </span>
                </div>
                <form action="masInformacionTareas.php" method="POST" class="mt-2 w-full">
                    <input type="hidden" name="id_tarea" value="<?php echo $idTarea; ?>">
                    <button type="submit" class="cursor-pointer inline-block w-full text-center text-white bg-gradient-to-r from-blue-600 via-blue-500 to-blue-700 hover:from-blue-700 hover:to-blue-800 font-bold rounded-lg text-sm px-5 py-2.5 shadow-lg transition">
                        Más información
                    </button>
                </form>
            </div>
        <?php
        }
    }
    public function mostrarTareasEA($id)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT id_tarea, titulo_tarea, descripcion_tarea, prioridad_tarea, estado_tarea FROM tareas WHERE id_usuario_tareas = $id ORDER BY estado_tarea ASC";
        $resultado = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_array($resultado)) {
            $idTarea = $fila["id_tarea"];
        ?>
            <div class="flex flex-col items-center lg:items-start bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 px-5 py-4 border border-blue-100 dark:border-gray-600 mb-4">
		<h3 class="text-2xl font-bold text-blue-900 dark:text-white mb-2 max-w-full overflow-hidden"
                    style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; white-space: normal;"
                    title="<?php echo $fila["titulo_tarea"]; ?>">
                    <?php echo $fila["titulo_tarea"]; ?>
                </h3>                <p class="w-full text-center lg:text-left text-md text-gray-700 dark:text-gray-300 mb-3 truncate">
                    <?php echo $fila["descripcion_tarea"]; ?>
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["prioridad_tarea"] == "alta") {
                        echo "bg-red-500 text-white";
                    } elseif ($fila["prioridad_tarea"] == "media") {
                        echo "bg-amber-400 text-white";
                    } elseif ($fila["prioridad_tarea"] == "baja") {
                        echo "bg-green-500 text-white";
                    }
                    ?>">
                        Prioridad: <?php echo ucfirst($fila["prioridad_tarea"]); ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["estado_tarea"] == "finalizada") {
                        echo "bg-green-400 text-white";
                    } elseif ($fila["estado_tarea"] == "progresando") {
                        echo "bg-violet-400 text-white";
                    } elseif ($fila["estado_tarea"] == "suspendida") {
                        echo "bg-amber-400 text-white";
                    }
                    ?>">
                        Estado: <?php echo ucfirst($fila["estado_tarea"]); ?>
                    </span>
                </div>
                <form action="masInformacionTareas.php" method="POST" class="mt-2 w-full">
                    <input type="hidden" name="id_tarea" value="<?php echo $idTarea; ?>">
                    <button type="submit" class="cursor-pointer inline-block w-full text-center text-white bg-gradient-to-r from-blue-600 via-blue-500 to-blue-700 hover:from-blue-700 hover:to-blue-800 font-bold rounded-lg text-sm px-5 py-2.5 shadow-lg transition">
                        Más información
                    </button>
                </form>
            </div>
        <?php
        }
    }
    public function mostrarTareasFD($id)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT id_tarea, titulo_tarea, descripcion_tarea, prioridad_tarea, estado_tarea, creacion_tarea FROM tareas WHERE id_usuario_tareas = $id ORDER BY creacion_tarea DESC";
        $resultado = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_array($resultado)) {
            $idTarea = $fila["id_tarea"];
        ?>
            <div class="flex flex-col items-center lg:items-start bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 px-5 py-4 border border-blue-100 dark:border-gray-600 mb-4">
		<h3 class="text-2xl font-bold text-blue-900 dark:text-white mb-2 max-w-full overflow-hidden"
                    style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; white-space: normal;"
                    title="<?php echo $fila["titulo_tarea"]; ?>">
                    <?php echo $fila["titulo_tarea"]; ?>
                </h3>                <p class="w-full text-center lg:text-left text-md text-gray-700 dark:text-gray-300 mb-3 truncate">
                    <?php echo $fila["descripcion_tarea"]; ?>
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["prioridad_tarea"] == "alta") {
                        echo "bg-red-500 text-white";
                    } elseif ($fila["prioridad_tarea"] == "media") {
                        echo "bg-amber-400 text-white";
                    } elseif ($fila["prioridad_tarea"] == "baja") {
                        echo "bg-green-500 text-white";
                    }
                    ?>">
                        Prioridad: <?php echo ucfirst($fila["prioridad_tarea"]); ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["estado_tarea"] == "finalizada") {
                        echo "bg-green-400 text-white";
                    } elseif ($fila["estado_tarea"] == "progresando") {
                        echo "bg-violet-400 text-white";
                    } elseif ($fila["estado_tarea"] == "suspendida") {
                        echo "bg-amber-400 text-white";
                    }
                    ?>">
                        Estado: <?php echo ucfirst($fila["estado_tarea"]); ?>
                    </span>
                </div>
                <form action="masInformacionTareas.php" method="POST" class="mt-2 w-full">
                    <input type="hidden" name="id_tarea" value="<?php echo $idTarea; ?>">
                    <button type="submit" class="cursor-pointer inline-block w-full text-center text-white bg-gradient-to-r from-blue-600 via-blue-500 to-blue-700 hover:from-blue-700 hover:to-blue-800 font-bold rounded-lg text-sm px-5 py-2.5 shadow-lg transition">
                        Más información
                    </button>
                </form>
            </div>
        <?php
        }
    }
    public function mostrarTareasFA($id)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT id_tarea, titulo_tarea, descripcion_tarea, prioridad_tarea, estado_tarea, creacion_tarea FROM tareas WHERE id_usuario_tareas = $id ORDER BY creacion_tarea ASC";
        $resultado = mysqli_query($conexion, $sql);
        while ($fila = mysqli_fetch_array($resultado)) {
            $idTarea = $fila["id_tarea"];
        ?>
            <div class="flex flex-col items-center lg:items-start bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 px-5 py-4 border border-blue-100 dark:border-gray-600 mb-4">
		<h3 class="text-2xl font-bold text-blue-900 dark:text-white mb-2 max-w-full overflow-hidden"
                    style="display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; white-space: normal;"
                    title="<?php echo $fila["titulo_tarea"]; ?>">
                    <?php echo $fila["titulo_tarea"]; ?>
                </h3>                <p class="w-full text-center lg:text-left text-md text-gray-700 dark:text-gray-300 mb-3 truncate">
                    <?php echo $fila["descripcion_tarea"]; ?>
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["prioridad_tarea"] == "alta") {
                        echo "bg-red-500 text-white";
                    } elseif ($fila["prioridad_tarea"] == "media") {
                        echo "bg-amber-400 text-white";
                    } elseif ($fila["prioridad_tarea"] == "baja") {
                        echo "bg-green-500 text-white";
                    }
                    ?>">
                        Prioridad: <?php echo ucfirst($fila["prioridad_tarea"]); ?>
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                    <?php
                    if ($fila["estado_tarea"] == "finalizada") {
                        echo "bg-green-400 text-white";
                    } elseif ($fila["estado_tarea"] == "progresando") {
                        echo "bg-violet-400 text-white";
                    } elseif ($fila["estado_tarea"] == "suspendida") {
                        echo "bg-amber-400 text-white";
                    }
                    ?>">
                        Estado: <?php echo ucfirst($fila["estado_tarea"]); ?>
                    </span>
                </div>
                <form action="masInformacionTareas.php" method="POST" class="mt-2 w-full">
                    <input type="hidden" name="id_tarea" value="<?php echo $idTarea; ?>">
                    <button type="submit" class="cursor-pointer inline-block w-full text-center text-white bg-gradient-to-r from-blue-600 via-blue-500 to-blue-700 hover:from-blue-700 hover:to-blue-800 font-bold rounded-lg text-sm px-5 py-2.5 shadow-lg transition">
                        Más información
                    </button>
                </form>
            </div>
        <?php
        }
    }
    public function mostrarArchivoTarea($id)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT * FROM archivostareas WHERE id_tarea_archivoTarea = $id";
        $resultado = mysqli_query($conexion, $sql);
        return $resultado;
    }
    public function mostrarArchivoProyecto($id_proyecto)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT * FROM archivosproyectos WHERE id_proyecto_archivosproyectos = $id_proyecto";
        $resultado = mysqli_query($conexion, $sql);
        return $resultado;
    }

    public function cantidadTareasUsuario($id_usuario)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT COUNT(*) AS total FROM tareas WHERE id_usuario_tareas = $id_usuario";
        $resultado = mysqli_query($conexion, $sql);
        $resultadoFinal = mysqli_fetch_assoc($resultado);
        return $resultadoFinal['total'];
    }
    public function cantidadProyectosUsuario($id_usuario)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT COUNT(*) AS total 
            FROM usuariosproyectos 
            WHERE id_usuario_usuariosproyectos = $id_usuario";
        $resultado = mysqli_query($conexion, $sql);
        $resultadoFinal = mysqli_fetch_assoc($resultado);
        return $resultadoFinal['total'];
    }
    public function cantidadNotificacionesUsuario($id_usuario)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT COUNT(*) AS total FROM tareas WHERE id_usuario_tareas = $id_usuario AND creacion_tarea <= DATE_SUB(CURDATE(), INTERVAL 5 DAY)";
        $resultado = mysqli_query($conexion, $sql);
        $resultadoFinal = mysqli_fetch_assoc($resultado);
        return $resultadoFinal['total'];
    }
    public function informacionUsuario($id_usuario)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
        $resultado = mysqli_query($conexion, $sql);
        $resultadoFinal = mysqli_fetch_assoc($resultado);
        return $resultadoFinal;
    }
    public function mostrarProyectosUsuario($id_usuario)
    {
        $c = new conexion;
        $conexion = $c->conectar();

        // Consulta para obtener los proyectos a los que el usuario está unido (relación varios a varios)
        $sql = "SELECT 
                p.id_proyecto, 
                p.nombre_proyecto AS titulo, 
                p.descripcion_proyecto AS descripcion, 
                p.prioridad_proyecto AS prioridad, 
                p.estado_proyecto AS estado
            FROM proyectos p
            INNER JOIN usuariosproyectos up ON p.id_proyecto = up.id_proyecto_usuariosproyectos
            WHERE up.id_usuario_usuariosproyectos = $id_usuario";
        $resultado = mysqli_query($conexion, $sql);

        // Contamos los proyectos
        $numProyectos = mysqli_num_rows($resultado);

        // Estructura de cartas de proyectos
        ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mx-3 mt-6 justify-center items-center place-items-center">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 w-full max-w-4xl mx-auto col-span-1 sm:col-span-2 lg:col-span-3">
                <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white text-center">Proyectos creados</h2>
                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 justify-center items-center">
                    <?php
                    if ($numProyectos > 0) {
                        mysqli_data_seek($resultado, 0); // Reiniciar puntero por si acaso
                        while ($proyecto = mysqli_fetch_assoc($resultado)) {
                    ?>
                            <div class="p-4 rounded-lg shadow mx-auto w-full max-w-xs"
                                style="background: linear-gradient(135deg, #1e293b 60%, #60a5fa 100%); background-blend-mode: lighten;">
                                <div class="font-semibold text-lg text-gray-900 dark:text-white text-center w-full block truncate" style="max-width: 300px;" title="<?php echo $proyecto['titulo']; ?>">
                                    <?php echo $proyecto['titulo']; ?>
                                </div>
                                <div class="text-sm mb-2 text-gray-800 dark:text-gray-200 text-center w-full block truncate" style="max-width: 300px;" title="<?php echo $proyecto['descripcion']; ?>">
                                    <?php echo $proyecto['descripcion']; ?>
                                </div>
                                <div class="flex flex-wrap gap-2 mt-2 justify-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
        <?php
                            if ($proyecto["prioridad"] == "alta") {
                                echo "bg-red-500 text-white";
                            } elseif ($proyecto["prioridad"] == "media") {
                                echo "bg-amber-400 text-white";
                            } elseif ($proyecto["prioridad"] == "baja") {
                                echo "bg-green-500 text-white";
                            }
        ?>">
                                        Prioridad: <?php echo ucfirst($proyecto["prioridad"]); ?>
                                    </span>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
        <?php
                            if ($proyecto["estado"] == "activo") {
                                echo "bg-green-400 text-white";
                            } elseif ($proyecto["estado"] == "pendiente") {
                                echo "bg-violet-400 text-white";
                            } elseif ($proyecto["estado"] == "completado") {
                                echo "bg-blue-400 text-white";
                            }
        ?>">
                                        Estado: <?php echo ucfirst($proyecto["estado"]); ?>
                                    </span>
                                </div>
                                <form action="masInformacionProyecto.php" method="POST" class="mt-4 w-full">
                                    <input type="hidden" name="id_proyecto" value="<?php echo htmlspecialchars($proyecto['id_proyecto']); ?>">
                                    <button type="submit" class="cursor-pointer inline-block w-full text-center text-white bg-gradient-to-r from-blue-600 via-blue-500 to-blue-700 hover:from-blue-700 hover:to-blue-800 font-bold rounded-lg text-sm px-5 py-2.5 shadow-lg transition">
                                        Más información
                                    </button>
                                </form>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="col-span-full flex flex-col items-center justify-center py-12">
                            <svg class="w-16 h-16 mb-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p class="text-xl font-semibold text-center text-gray-700 dark:text-gray-200">¡No tienes proyectos creados!</p>
                            <p class="text-gray-400 mt-2 text-center">Cuando crees un proyecto aparecerá aquí.</p>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
<?php
    }
    public function generarCodigoProyectoUnico()
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&*';

        do {
            $codigo = '';
            for ($i = 0; $i < 10; $i++) {
                $codigo .= $caracteres[random_int(0, strlen($caracteres) - 1)];
            }
            $sql = "SELECT COUNT(*) as total FROM proyectos WHERE codigo_proyecto = '$codigo'";
            $resultado = mysqli_query($conexion, $sql);
            $existe = mysqli_fetch_assoc($resultado)['total'] > 0;
        } while ($existe);

        return $codigo;
    }
    public function obtenerCodigoProyecto($id_proyecto)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT codigo_proyecto FROM proyectos WHERE id_proyecto = $id_proyecto";
        $resultado = mysqli_query($conexion, $sql);
        if ($resultado && $fila = mysqli_fetch_assoc($resultado)) {
            return $fila['codigo_proyecto'];
        }
        return null;
    }
    public function obtenerIdProyectoPorCodigo($codigo_proyecto)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT id_proyecto FROM proyectos WHERE codigo_proyecto = '$codigo_proyecto'";
        $resultado = mysqli_query($conexion, $sql);
        if ($fila = mysqli_fetch_assoc($resultado)) {
            return $fila['id_proyecto'];
        }
        return null;
    }

    public function usuarioYaUnidoAProyecto($id_usuario, $id_proyecto)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "SELECT 1 FROM usuariosproyectos WHERE id_usuario_usuariosproyectos = $id_usuario AND id_proyecto_usuariosproyectos = $id_proyecto";
        $resultado = mysqli_query($conexion, $sql);
        return mysqli_num_rows($resultado) > 0;
    }
}
