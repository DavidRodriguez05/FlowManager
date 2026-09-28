const password = document.querySelector("#password");
const passwordLabel = document.querySelector('label[for="password"]');

const confirmPassword = document.querySelector("#confirm-password");
const confirmPasswordLabel = document.querySelector(
    'label[for="confirm-password"]'
);

const checkbox = document.querySelector("#newsletter");
const submitBtn = document.querySelector("#enviarForm");

let validPassword = false;
let validConfirmPassword = false;
let validCheckbox = false;

function validarPassword() {
    const value = password.value;
    const caracteresEspeciales = /[!@#$%^&*()/,.?":{}|<>]/;
    const mayusculas = /[A-Z]/;
    const minusculas = /[a-z]/;
    const numeros = /[0-9]/;

    if (value.length === 0) {
        passwordLabel.innerHTML = "Nueva Contraseña";
        passwordLabel.classList.remove("erroneo", "correcto");
        validPassword = false;
    } else if (value.length < 8) {
        passwordLabel.innerHTML = "Mínimo 8 caracteres";
        passwordLabel.classList.add("erroneo");
        passwordLabel.classList.remove("correcto");
        validPassword = false;
    } else if (!caracteresEspeciales.test(value)) {
        passwordLabel.innerHTML = "Usa caracteres especiales";
        passwordLabel.classList.add("erroneo");
        passwordLabel.classList.remove("correcto");
        validPassword = false;
    } else if (!mayusculas.test(value)) {
        passwordLabel.innerHTML = "Usa mayúsculas";
        passwordLabel.classList.add("erroneo");
        passwordLabel.classList.remove("correcto");
        validPassword = false;
    } else if (!minusculas.test(value)) {
        passwordLabel.innerHTML = "Usa minúsculas";
        passwordLabel.classList.add("erroneo");
        passwordLabel.classList.remove("correcto");
        validPassword = false;
    } else if (!numeros.test(value)) {
        passwordLabel.innerHTML = "Usa números";
        passwordLabel.classList.add("erroneo");
        passwordLabel.classList.remove("correcto");
        validPassword = false;
    } else {
        passwordLabel.innerHTML = "Nueva Contraseña";
        passwordLabel.classList.remove("erroneo");
        passwordLabel.classList.add("correcto");
        validPassword = true;
    }
    validarFormulario();
}

function validarConfirmPassword() {
    if (confirmPassword.value.length === 0) {
        confirmPasswordLabel.innerHTML = "Confirmar Contraseña";
        confirmPasswordLabel.classList.remove("erroneo", "correcto");
        validConfirmPassword = false;
    } else if (confirmPassword.value !== password.value) {
        confirmPasswordLabel.innerHTML = "No coinciden";
        confirmPasswordLabel.classList.add("erroneo");
        confirmPasswordLabel.classList.remove("correcto");
        validConfirmPassword = false;
    } else {
        confirmPasswordLabel.innerHTML = "Confirmar Contraseña";
        confirmPasswordLabel.classList.remove("erroneo");
        confirmPasswordLabel.classList.add("correcto");
        validConfirmPassword = true;
    }
    validarFormulario();
}

function validarCheckbox() {
    validCheckbox = checkbox.checked;
    validarFormulario();
}

function validarFormulario() {
    if (validPassword && validConfirmPassword && validCheckbox) {
        submitBtn.removeAttribute("disabled");
    } else {
        submitBtn.setAttribute("disabled", true);
    }
}

// Eventos
password.addEventListener("input", validarPassword);
confirmPassword.addEventListener("input", validarConfirmPassword);
checkbox.addEventListener("change", validarCheckbox);

// Deshabilita el botón al cargar
submitBtn.setAttribute("disabled", true);
