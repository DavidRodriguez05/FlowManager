<?php
// Plantilla de configuración.
// Copia este archivo como config.php (en esta misma carpeta) y rellena tus datos.
// config.php está en .gitignore, así que tus credenciales nunca se suben a GitHub.
return [
    'db' => [
        'host' => 'localhost',
        'user' => 'tu_usuario',
        'password' => 'tu_contraseña',
        'name' => 'tfg-gestor',
    ],
    'mail' => [
        // Cuenta de Gmail con una "contraseña de aplicación" (no la contraseña normal de la cuenta)
        'username' => 'tu_correo@gmail.com',
        'password' => 'tu_contraseña_de_aplicación',
        'from_email' => 'tu_correo@gmail.com',
    ],
    'openai_api_key' => 'tu_clave_de_openai',
];
