<?php
class delete
{
    public function deleteAll($tabla, $where)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "DELETE FROM $tabla WHERE $where";
        mysqli_query($conexion, $sql);
    }
    public function deleteAllLimit($tabla, $where, $limit)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "DELETE FROM $tabla WHERE $where LIMIT $limit";
        mysqli_query($conexion, $sql);
    }
    public function eliminarTarea($id)
    {
        $c = new conexion;
        $conexion = $c->conectar();

        // 1. Buscar archivos asociados a la tarea
        $sqlArchivos = "SELECT nombre_archivoTarea FROM archivostareas WHERE id_tarea_archivoTarea = $id";
        $resultado = mysqli_query($conexion, $sqlArchivos);

        while ($fila = mysqli_fetch_assoc($resultado)) {
            $archivo = $fila['nombre_archivoTarea'];
            $rutaArchivo = "../../archive/tareas/" . $archivo; // <-- AJUSTA ESTA RUTA

            // 2. Eliminar el archivo físicamente si existe
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
        }

        // 4. Eliminar la tarea
        $sqlTarea = "DELETE FROM tareas WHERE id_tarea = $id";
        mysqli_query($conexion, $sqlTarea);

        return true;
    }
    public function eliminarProyecto($id)
    {
        $c = new conexion;
        $conexion = $c->conectar();

        // 1. Buscar archivos asociados a la tarea
        $sqlArchivos = "SELECT nombre_archivosproyectos FROM archivosproyectos WHERE id_proyecto_archivosproyectos  = $id";
        $resultado = mysqli_query($conexion, $sqlArchivos);

        while ($fila = mysqli_fetch_assoc($resultado)) {
            $archivo = $fila['nombre_archivosproyectos'];
            $rutaArchivo = "../../archive/proyectos/" . $archivo; // <-- AJUSTA ESTA RUTA

            // 2. Eliminar el archivo físicamente si existe
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
        }

        // 4. Eliminar la tarea
        $sqlTarea = "DELETE FROM proyectos WHERE id_proyecto = $id";
        mysqli_query($conexion, $sqlTarea);

        return true;
    }
    public function eliminarArchivoTarea($id_archivo, $id_tarea)
    {
        $c = new conexion;
        $conexion = $c->conectar();

        // 1. Buscar el nombre del archivo en la BBDD antes de eliminar el registro
        $sqlBuscar = "SELECT nombre_archivoTarea FROM archivostareas WHERE id_archivoTarea = $id_archivo";
        $resBuscar = mysqli_query($conexion, $sqlBuscar);
        $archivo = null;
        if ($fila = mysqli_fetch_assoc($resBuscar)) {
            $archivo = $fila['nombre_archivoTarea'];
        }

        // 2. Eliminar el registro de la BBDD
        $sql = "DELETE FROM archivostareas WHERE id_archivoTarea = $id_archivo";
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            // 3. Eliminar el archivo físico si existe
            if ($archivo) {
                $rutaArchivo = "../../archive/tareas/" . $archivo;
                if (file_exists($rutaArchivo)) {
                    unlink($rutaArchivo);
                }
            }
            $_SESSION["id_tarea"] = $id_tarea;
            echo "<script>window.location=document.referrer;</script>";
            exit;
        } else {
            echo "<div style='
            background: linear-gradient(90deg, #f87171, #fbbf24);
            color: white;
            padding: 20px;
            border-radius: 12px;
            font-size: 1.2rem;
            text-align: center;
            margin: 40px auto;
            max-width: 400px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.15);
        '>
            <strong>Error:</strong> No se pudo eliminar el archivo.<br>
            <a href='javascript:history.back()' style='color:#fff; text-decoration:underline;'>Volver atrás</a>
        </div>";
            return false;
        }
    }
    public function eliminarArchivoProyecto($id_archivo, $id_proyecto)
    {
        $c = new conexion;
        $conexion = $c->conectar();

        // 1. Buscar el nombre del archivo en la BBDD antes de eliminar el registro
        $sqlBuscar = "SELECT nombre_archivosproyectos FROM archivosproyectos WHERE id_archivosproyectos = $id_archivo";
        $resBuscar = mysqli_query($conexion, $sqlBuscar);
        $archivo = null;
        if ($fila = mysqli_fetch_assoc($resBuscar)) {
            $archivo = $fila['nombre_archivosproyectos'];
        }

        // 2. Eliminar el registro de la BBDD
        $sql = "DELETE FROM archivosproyectos WHERE id_archivosproyectos = $id_archivo";
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            // 3. Eliminar el archivo físico si existe
            if ($archivo) {
                $rutaArchivo = "../../archive/proyectos/" . $archivo;
                if (file_exists($rutaArchivo)) {
                    unlink($rutaArchivo);
                }
            }
            $_SESSION["id_proyecto"] = $id_proyecto;
            echo "<script>window.location=document.referrer;</script>";
            exit;
        } else {
            echo "<div style='
        background: linear-gradient(90deg, #f87171, #fbbf24);
        color: white;
        padding: 20px;
        border-radius: 12px;
        font-size: 1.2rem;
        text-align: center;
        margin: 40px auto;
        max-width: 400px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.15);
    '>
        <strong>Error:</strong> No se pudo eliminar el archivo.<br>
        <a href='javascript:history.back()' style='color:#fff; text-decoration:underline;'>Volver atrás</a>
    </div>";
            return false;
        }
    }
    public function eliminarCuenta($id_usuario)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "DELETE FROM usuarios WHERE id_usuario = $id_usuario";
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            return true;
            /*
            echo "<script>window.location=document.referrer;</script>";
            exit;
            */
        } else {

            echo "<div style='
                background: linear-gradient(90deg, #f87171, #fbbf24);
                color: white;
                padding: 20px;
                border-radius: 12px;
                font-size: 1.2rem;
                text-align: center;
                margin: 40px auto;
                max-width: 400px;
                box-shadow: 0 4px 24px rgba(0,0,0,0.15);
            '>
                <strong>Error:</strong> No se pudo eliminar la cuenta.<br>
                <a href='javascript:history.back()' style='color:#fff; text-decoration:underline;'>Volver atrás</a>
            </div>";
            exit;
        }
    }
}
