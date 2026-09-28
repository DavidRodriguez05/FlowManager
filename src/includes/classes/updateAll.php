<?php
class updateAllClass
{
    public function updateAllWhere($tabla, $set, $where)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "UPDATE $tabla SET $set WHERE $where";
        mysqli_query($conexion, $sql);
    }

    public function updateAllWhereLimit($tabla, $set, $where, $limit)
    {
        $c = new conexion();
        $conexion = $c->conectar();
        $sql = "UPDATE $tabla SET $set WHERE $where LIMIT $limit";
        mysqli_query($conexion, $sql);
    }
    public function modificarTarea($id_tarea, $datos)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "UPDATE tareas SET 
        titulo_tarea = '" . mysqli_real_escape_string($conexion, $datos[0]) . "',
        descripcion_tarea = '" . mysqli_real_escape_string($conexion, $datos[1]) . "',
        prioridad_tarea = '" . mysqli_real_escape_string($conexion, $datos[2]) . "',
        estado_tarea = '" . mysqli_real_escape_string($conexion, $datos[3]) . "'
        WHERE id_tarea = " . intval($id_tarea);

        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
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
            <strong>Error:</strong> No se pudo modificar la tarea.<br>
            <a href='javascript:history.back()' style='color:#fff; text-decoration:underline;'>Volver atrás</a>
        </div>";
            exit;
        }
    }
    public function modificarProyecto($id_proyecto, $datos)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "UPDATE proyectos SET 
        nombre_proyecto = '" . mysqli_real_escape_string($conexion, $datos[0]) . "',
        descripcion_proyecto = '" . mysqli_real_escape_string($conexion, $datos[1]) . "',
        prioridad_proyecto = '" . mysqli_real_escape_string($conexion, $datos[2]) . "',
        estado_proyecto = '" . mysqli_real_escape_string($conexion, $datos[3]) . "'
        WHERE id_proyecto = " . intval($id_proyecto);

        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
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
            <strong>Error:</strong> No se pudo modificar el proyecto.<br>
            <a href='javascript:history.back()' style='color:#fff; text-decoration:underline;'>Volver atrás</a>
        </div>";
            exit;
        }
    }
    public function modificarUsuario($id, $datos)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        $sql = "UPDATE usuarios SET 
        nombre_usuario = '" . mysqli_real_escape_string($conexion, $datos[0]) . "',
        avatar_usuario = '" . mysqli_real_escape_string($conexion, $datos[1]) . "'
        WHERE id_usuario = " . intval($id);

        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            $_SESSION["usuario"] = $datos[0];
            $_SESSION["avatar"] = $datos[1];
            return true;
        } else {
            // Error bonito con botón de volver
            echo "<div style='
            background: linear-gradient(90deg, #f87171, #fbbf24);
            color: white;
            padding: 32px 24px;
            border-radius: 16px;
            font-size: 1.2rem;
            text-align: center;
            margin: 60px auto;
            max-width: 420px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
        '>
            <strong>Error:</strong> No se pudo modificar el perfil.<br><br>
            <a href=\"../../php/miPerfil.php\" style=\"
                display: inline-block;
                margin-top: 18px;
                padding: 10px 28px;
                background: linear-gradient(90deg, #2563eb, #1e40af);
                color: #fff;
                border-radius: 8px;
                text-decoration: none;
                font-weight: bold;
                box-shadow: 0 2px 8px rgba(30,64,175,0.15);
                transition: background 0.2s;
            \" onmouseover=\"this.style.background='linear-gradient(90deg,#1e40af,#2563eb)'\">
                Volver a mi perfil
            </a>
        </div>";
            exit;
        }
    }
    public function modificarPassword($id_usuario, $password)
    {
        $c = new conexion;
        $conexion = $c->conectar();
        // Escapar el hash por seguridad
        $passwordEscapado = mysqli_real_escape_string($conexion, $password);
        $sql = "UPDATE usuarios SET password_usuario = '$passwordEscapado' WHERE id_usuario = " . intval($id_usuario);

        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            header("Location: ../miPerfil.php");
            return true;
        } else {
            echo "<div style='
                background: linear-gradient(90deg, #f87171, #fbbf24);
                color: white;
                padding: 32px 24px;
                border-radius: 16px;
                font-size: 1.2rem;
                text-align: center;
                margin: 60px auto;
                max-width: 420px;
                box-shadow: 0 4px 24px rgba(0,0,0,0.18);
            '>
                <strong>Error:</strong> No se pudo modificar la contraseña.<br><br>
                <a href=\"../../php/miPerfil.php\" style=\"
                    display: inline-block;
                    margin-top: 18px;
                    padding: 10px 28px;
                    background: linear-gradient(90deg, #2563eb, #1e40af);
                    color: #fff;
                    border-radius: 8px;
                    text-decoration: none;
                    font-weight: bold;
                    box-shadow: 0 2px 8px rgba(30,64,175,0.15);
                    transition: background 0.2s;
                \" onmouseover=\"this.style.background='linear-gradient(90deg,#1e40af,#2563eb)'\">
                    Volver a mi perfil
                </a>
            </div>";
            exit;
        }
    }
}
