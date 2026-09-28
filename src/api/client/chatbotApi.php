<?php
header('Content-Type: application/json');

// La clave está en src/config/config.php (no se sube a GitHub)
require_once __DIR__ . '/../../config/load.php';
$apiKey = flowmanager_config()['openai_api_key'];

$input = json_decode(file_get_contents('php://input'), true);
$prompt = isset($input['prompt']) ? trim($input['prompt']) : '';

if (!$prompt) {
    echo json_encode(['respuesta' => 'No se recibió ninguna pregunta.']);
    exit;
}

$ch = curl_init('https://api.openai.com/v1/chat/completions');
$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "Eres un asistente útil para gestión de proyectos."],
        ["role" => "user", "content" => $prompt]
    ],
    "max_tokens" => 200,
    "temperature" => 0.7
];

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo json_encode(['respuesta' => 'Error al conectar con OpenAI.']);
    curl_close($ch);
    exit;
}
curl_close($ch);

$result = json_decode($response, true);
if (isset($result['choices'][0]['message']['content'])) {
    echo json_encode(['respuesta' => trim($result['choices'][0]['message']['content'])]);
} else {
    echo json_encode(['respuesta' => 'No se pudo obtener respuesta de OpenAI.']);
}
