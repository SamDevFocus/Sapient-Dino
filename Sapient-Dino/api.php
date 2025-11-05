<?php
// chat.php
// Endpoint que recebe POST { message: "texto", conversation_id: optional }
// Retorna JSON { success: true, reply: "texto do assistant", messages: [...] }

header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Use POST']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!isset($data['message']) || trim($data['message']) === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Mensagem vazia']);
    exit;
}

$userMessage = trim($data['message']);

// --- Configuração da chave ---
// Recomendado: definir a chave como variavel de ambiente no servidor, ex: OPENAI_API_KEY
$apiKey = '';

// Se quiser testar localmente e nao usar variavel de ambiente, descomente a linha abaixo
// $apiKey = 'sk-...SEU_TOKEN_AQUI...';

if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'API key nao configurada no servidor']);
    exit;
}

// --- Construir o histórico de conversa (simples) ---
// Opcional: voce pode manter um historico por session/arquivo/banco. Aqui criaremos um historico minimal
// que coloca a pergunta do usuario como ultimo item junto com um system prompt inicial.
$system_prompt = "Você é um assistente útil que responde em português de forma clara e objetiva.";

$payload = [
    "model" => "gpt-4o-mini", // Caso nao tenha acesso, troque para "gpt-4o" ou "gpt-3.5-turbo"
    "messages" => [
        ["role" => "system", "content" => $system_prompt],
        ["role" => "user", "content" => $userMessage]
    ],
    "temperature" => 0.2,
    "max_tokens" => 1000,
];

// Faz a requisicao para a API da OpenAI
$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer {$apiKey}"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_TIMEOUT, 60);

$response = curl_exec($ch);
$err = curl_error($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($err) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Curl error: ' . $err]);
    exit;
}

if ($httpcode >= 400) {
    http_response_code($httpcode);
    echo json_encode(['success' => false, 'error' => 'OpenAI API returned HTTP ' . $httpcode, 'body' => $response]);
    exit;
}

$respJson = json_decode($response, true);
if (!$respJson) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Resposta invalida da OpenAI', 'body' => $response]);
    exit;
}

// extrai texto do assistant (assumindo formato chat completions)
$assistantText = '';
if (isset($respJson['choices'][0]['message']['content'])) {
    $assistantText = $respJson['choices'][0]['message']['content'];
} elseif (isset($respJson['choices'][0]['text'])) {
    $assistantText = $respJson['choices'][0]['text'];
}

echo json_encode([
    'success' => true,
    'reply' => $assistantText,
    'raw' => $respJson
]);
