<?php
class insertarDatosClass
{
    public function insertar($datos)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        if (isset($datos[3])) {
            $sql = "INSERT INTO usuarios (nombre_usuario,email_usuario,password_usuario,avatar_usuario) VALUES ('$datos[0]','$datos[1]','$datos[2]','$datos[3]')";
        } else {
            $sql = "INSERT INTO usuarios (nombre_usuario,email_usuario,password_usuario) VALUES ('$datos[0]','$datos[1]','$datos[2]')";
        }
        $resultado = mysqli_query($conexion, $sql);
        return $resultado;
    }
    public function insertarTarea($datos)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "INSERT INTO tareas(id_usuario_tareas,titulo_tarea,descripcion_tarea,prioridad_tarea,estado_tarea) VALUES('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]')";

        if (!mysqli_query($conexion, $sql)) {
            echo "
            <div class='flex flex-col items-center justify-center min-h-screen bg-red-100'>
                <div class='bg-red-500 text-white font-bold rounded-lg border shadow-lg p-10'>
                    <p>Error al insertar la tarea: " . mysqli_error($conexion) . "</p>
                    <a href='javascript:history.back()' class='mt-4 inline-block bg-white text-red-500 font-medium py-2 px-4 rounded hover:bg-gray-200'>Volver atrás</a>
                </div>
            </div>";
            exit;
        }

        // Redirigir a la página anterior si todo salió bien
        return mysqli_insert_id($conexion);
    }
    public function insertarProyecto($datos)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "INSERT INTO proyectos(nombre_proyecto,descripcion_proyecto,prioridad_proyecto,estado_proyecto,codigo_proyecto) VALUES('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]')";

        if (!mysqli_query($conexion, $sql)) {
            echo "
            <div class='flex flex-col items-center justify-center min-h-screen bg-red-100'>
                <div class='bg-red-500 text-white font-bold rounded-lg border shadow-lg p-10'>
                    <p>Error al insertar la tarea: " . mysqli_error($conexion) . "</p>
                    <a href='javascript:history.back()' class='mt-4 inline-block bg-white text-red-500 font-medium py-2 px-4 rounded hover:bg-gray-200'>Volver atrás</a>
                </div>
            </div>";
            exit;
        }

        // Redirigir a la página anterior si todo salió bien
        return mysqli_insert_id($conexion);
    }

    public function vincularProyectoUsuario($id_usuario, $id_proyecto)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "INSERT INTO usuariosproyectos(id_usuario_usuariosproyectos, id_proyecto_usuariosproyectos) VALUES($id_usuario, $id_proyecto)";
        if (!mysqli_query($conexion, $sql)) {
            echo "
        <div class='flex flex-col items-center justify-center min-h-screen bg-red-100'>
            <div class='bg-red-500 text-white font-bold rounded-lg border shadow-lg p-10'>
                <p>Error al vincular el usuario al proyecto: " . mysqli_error($conexion) . "</p>
                <a href='javascript:history.back()' class='mt-4 inline-block bg-white text-red-500 font-medium py-2 px-4 rounded hover:bg-gray-200'>Volver atrás</a>
            </div>
        </div>";
            exit;
        }
        return true;
    }
    public function insertarArchivoTarea($id_tarea, $datos)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "INSERT INTO archivostareas(id_tarea_archivoTarea,nombre_archivoTarea,tipo_archivoTarea) VALUES($id_tarea,'$datos[0]','$datos[1]')";
        if (!mysqli_query($conexion, $sql)) {
            echo "
            <div class='flex flex-col items-center justify-center min-h-screen bg-red-100'>
                <div class='bg-red-500 text-white font-bold rounded-lg border shadow-lg p-10'>
                    <p>Error al insertar el archivo: " . mysqli_error($conexion) . "</p>
                    <a href='javascript:history.back()' class='mt-4 inline-block bg-white text-red-500 font-medium py-2 px-4 rounded hover:bg-gray-200'>Volver atrás</a>
                </div>
            </div>";
            exit;
        }
        return true;
    }
    public function insertarArchivoProyecto($id_proyecto, $datos)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "INSERT INTO archivosproyectos(id_proyecto_archivosproyectos ,nombre_archivosproyectos,tipo_archivosproyectos) VALUES($id_proyecto,'$datos[0]','$datos[1]')";
        if (!mysqli_query($conexion, $sql)) {
            echo "
            <div class='flex flex-col items-center justify-center min-h-screen bg-red-100'>
                <div class='bg-red-500 text-white font-bold rounded-lg border shadow-lg p-10'>
                    <p>Error al insertar el archivo: " . mysqli_error($conexion) . "</p>
                    <a href='javascript:history.back()' class='mt-4 inline-block bg-white text-red-500 font-medium py-2 px-4 rounded hover:bg-gray-200'>Volver atrás</a>
                </div>
            </div>";
            exit;
        }
        return true;
    }
}
