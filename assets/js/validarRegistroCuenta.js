const botonRegistrar = document.querySelector("#registrarBoton");

const username = document.querySelector("#username");
const usernameLaberl = document.querySelector("#usernameLabel");

const email = document.querySelector("#email");
const emailLabel = document.querySelector("#emailLabel");

const password = document.querySelector("#password");
const passwordLabel = document.querySelector("#passwordLabel");

const confirmpassword = document.querySelector("#confirm-password");
const confirmPasswordLabel = document.querySelector("#confirmPasswordLabel");

const avatar = document.querySelector("#username-file");
const avatarLabel = document.querySelector("#username-fileLabel");

botonRegistrar.setAttribute("disabled", true);

let verificadoUsername = false;

// Validación para el campo de nombre de usuario
username.addEventListener("input", () => {
    const caracteresEspeciales = /[!@#$%^&*()/,.?":{}|<>]/; // Expresión regular para caracteres especiales
    const soloLetrasNumeros = /^[a-zA-Z0-9]+$/; // Solo letras y números

    if (username.value.length === 0) {
        usernameLaberl.innerHTML = "Nombre de usuario";
        usernameLaberl.classList.remove("erroneo");
        usernameLaberl.classList.remove("correcto");
        verificadoUsername = false;
        enviarFormulario();
    } else if (username.value.length < 5) {
        usernameLaberl.innerHTML =
            "El usuario debe tener al menos 5 caracteres";
        usernameLaberl.classList.add("erroneo");
        usernameLaberl.classList.remove("correcto");
        verificadoUsername = false;
        enviarFormulario();
    } else if (username.value.length > 20) {
        usernameLaberl.innerHTML =
            "El usuario no puede tener mas de 20 caracteres";
        usernameLaberl.classList.add("erroneo");
        usernameLaberl.classList.remove("correcto");
        verificadoUsername = false;
        enviarFormulario();
    } else if (caracteresEspeciales.test(username.value)) {
        usernameLaberl.innerHTML =
            "El usuario no puede contener caracteres especiales";
        usernameLaberl.classList.add("erroneo");
        usernameLaberl.classList.remove("correcto");
        verificadoUsername = false;
        enviarFormulario();
    } else if (!soloLetrasNumeros.test(username.value)) {
        usernameLaberl.innerHTML =
            "El usuario solo puede contener letras y números";
        usernameLaberl.classList.add("erroneo");
        usernameLaberl.classList.remove("correcto");
        verificadoUsername = false;
        enviarFormulario();
    } else {
        usernameLaberl.innerHTML = "Nombre de usuario";
        usernameLaberl.classList.remove("erroneo");
        usernameLaberl.classList.add("correcto");
        verificadoUsername = true;
        enviarFormulario();
    }
});

let verificadoEmail = false;
// Validación para el campo de email
email.addEventListener("input", () => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar emails

    if (email.value.length === 0) {
        emailLabel.innerHTML = "Correo electrónico";
        emailLabel.classList.remove("erroneo");
        emailLabel.classList.remove("correcto");
        verificadoEmail = false;
        enviarFormulario();
    } else if (email.value.length > 40) {
        emailLabel.innerHTML =
            "El Correo electrónico no puede ser mayor a 40 caracteres";
        emailLabel.classList.add("erroneo");
        emailLabel.classList.remove("correcto");
        verificadoEmail = false;
        enviarFormulario();
    } else if (!emailRegex.test(email.value)) {
        emailLabel.innerHTML = "El correo electrónico no es válido";
        emailLabel.classList.add("erroneo");
        emailLabel.classList.remove("correcto");
        verificadoEmail = false;
        çenviarFormulario();
    } else {
        emailLabel.innerHTML = "Correo electrónico";
        emailLabel.classList.remove("erroneo");
        emailLabel.classList.add("correcto");
        verificadoEmail = true;
        enviarFormulario();
    }
});

let verificadoPassword = false;
// Validación para el campo de password
password.addEventListener("input", () => {
    const caracteresEspeciales = /[!@#$%^&*()/,.?":{}|<>]/;
    const mayusculas = /[A-Z]/;
    const minusculas = /[a-z]/;
    const numeros = /[0-9]/;

    if (password.value.length === 0) {
        passwordLabel.innerHTML = "Contraseña";
        passwordLabel.classList.remove("erroneo");
        passwordLabel.classList.remove("correcto");
        verificadoPassword = false;
        enviarFormulario();
    } else if (password.value.length < 8) {
        passwordLabel.innerHTML = "Minimo 8 caracteres";
        passwordLabel.classList.add("erroneo");
        passwordLabel.classList.remove("correcto");
        verificadoPassword = false;
        enviarFormulario();
    } else if (!caracteresEspeciales.test(password.value)) {
        passwordLabel.innerHTML = "Usa caracteres especiales";
        passwordLabel.classList.add("erroneo");
        passwordLabel.classList.remove("correcto");
        verificadoPassword = false;
        enviarFormulario();
    } else if (!mayusculas.test(password.value)) {
        passwordLabel.innerHTML = "Usa mayúsculas";
        passwordLabel.classList.add("erroneo");
        passwordLabel.classList.remove("correcto");
        verificadoPassword = false;
        enviarFormulario();
    } else if (!minusculas.test(password.value)) {
        passwordLabel.innerHTML = "Usa minúsculas";
        passwordLabel.classList.add("erroneo");
        passwordLabel.classList.remove("correcto");
        verificadoPassword = false;
        enviarFormulario();
    } else if (!numeros.test(password.value)) {
        passwordLabel.innerHTML = "Usa números";
        passwordLabel.classList.add("erroneo");
        passwordLabel.classList.remove("correcto");
        verificadoPassword = false;
        enviarFormulario();
    } else {
        passwordLabel.innerHTML = "Correcta";
        passwordLabel.classList.remove("erroneo");
        passwordLabel.classList.add("correcto");
        verificadoPassword = true;
        enviarFormulario();
    }
});

let verificadoConfirmPassword = false;
// Validación para el campo de confirm-password
confirmpassword.addEventListener("input", () => {
    if (confirmpassword.value.length === 0) {
        confirmPasswordLabel.innerHTML = "Confirmar contraseña";
        confirmPasswordLabel.classList.remove("erroneo");
        confirmPasswordLabel.classList.remove("correcto");
        verificadoConfirmPassword = false;
        enviarFormulario();
    } else if (confirmpassword.value !== password.value) {
        confirmPasswordLabel.innerHTML = "No coinciden";
        confirmPasswordLabel.classList.add("erroneo");
        confirmPasswordLabel.classList.remove("correcto");
        verificadoConfirmPassword = false;
        enviarFormulario();
    } else {
        confirmPasswordLabel.innerHTML = "Correcta";
        confirmPasswordLabel.classList.remove("erroneo");
        confirmPasswordLabel.classList.add("correcto");
        verificadoConfirmPassword = true;
        enviarFormulario();
    }
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
    if (
        verificadoUsername === true &&
        verificadoEmail === true &&
        verificadoPassword === true &&
        verificadoConfirmPassword === true &&
        verificadoAvatar === true
    ) {
        botonRegistrar.removeAttribute("disabled");
    } else {
        botonRegistrar.setAttribute("disabled", true);
    }
}
