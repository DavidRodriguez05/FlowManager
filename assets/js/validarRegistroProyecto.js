document.addEventListener("DOMContentLoaded", function () {
    // Selecciona solo el formulario del modal de proyectos
    const formulario = document.querySelector("#addProjectModal form");
    if (!formulario) return;

    formulario.addEventListener("submit", function (evento) {
        let esValido = true;

        const titulo = document.getElementById("titulo");
        const descripcion = document.getElementById("descripcion");
        const prioridad = document.getElementById("prioridad");
        const estado = document.getElementById("estado");
        const archivo = document.getElementById("archivo");

        const mostrarError = (elemento, mensaje) => {
            let error = elemento.nextElementSibling;
            if (!error || !error.classList.contains("error-mensaje")) {
                error = document.createElement("p");
                error.classList.add(
                    "error-mensaje",
                    "text-sm",
                    "text-red-500",
                    "mt-3"
                );
                elemento.parentNode.appendChild(error);
            }
            error.textContent = mensaje;
        };

        const limpiarError = (elemento) => {
            const error = elemento.nextElementSibling;
            if (error && error.classList.contains("error-mensaje")) {
                error.remove();
            }
        };

        limpiarError(titulo);
        if (titulo.value.trim() === "") {
            mostrarError(titulo, "El nombre del proyecto es obligatorio");
            esValido = false;
        } else if (titulo.value.length > 150) {
            mostrarError(
                titulo,
                "El nombre del proyecto no puede superar los 150 caracteres"
            );
            esValido = false;
        }

        limpiarError(descripcion);
        if (descripcion.value.trim() === "") {
            mostrarError(descripcion, "La descripción es obligatoria");
            esValido = false;
        } else if (descripcion.value.length > 300) {
            mostrarError(
                descripcion,
                "La descripción no puede superar los 300 caracteres"
            );
            esValido = false;
        }

        limpiarError(prioridad);
        if (prioridad.value === "") {
            mostrarError(prioridad, "La prioridad es obligatoria");
            esValido = false;
        }

        limpiarError(estado);
        if (estado.value === "") {
            mostrarError(estado, "El estado es obligatorio");
            esValido = false;
        }

        limpiarError(archivo);
        if (archivo.files.length > 0) {
            const archivoSeleccionado = archivo.files[0];
            const tamanioMaximo = 5 * 1024 * 1024; // 5 MB en bytes
            const extensionesPermitidas = ["pdf", "docx", "xlsx", "png", "jpg"];

            const extensionArchivo = archivoSeleccionado.name
                .split(".")
                .pop()
                .toLowerCase();

            if (archivoSeleccionado.size > tamanioMaximo) {
                mostrarError(archivo, "El archivo no puede superar los 5 MB");
                esValido = false;
            } else if (!extensionesPermitidas.includes(extensionArchivo)) {
                mostrarError(
                    archivo,
                    "El archivo debe ser de tipo PDF, DOCX, XLSX, PNG o JPG"
                );
                esValido = false;
            }
        }

        if (!esValido) {
            evento.preventDefault();
        }
    });
});
