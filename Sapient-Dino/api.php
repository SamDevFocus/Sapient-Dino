<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(0); // oculta avisos que quebrariam o JSON

// Conexão com o banco
$host = 'localhost';
$db   = 'dino-db2';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erro na conexão: ' . $e->getMessage()]);
    exit;
}

// Verifica método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Use POST']);
    exit;
}

// Pega o JSON enviado
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!isset($data['message']) || trim($data['message']) === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Mensagem vazia']);
    exit;
}

$entradaUsuario = trim($data['message']);

// 1. Verifica se já existe no banco
$stmt = $pdo->prepare("SELECT resposta FROM respostas WHERE titulo = ?");
$stmt->execute([$entradaUsuario]);
$result = $stmt->fetch();

if ($result) {
    // Já existe — retorna do banco
    echo json_encode([
        'success' => true,
        'reply' => $result['resposta'],
        'fonte' => 'banco'
    ]);
    exit;
}

// 2. Chave da API
$apiKey = '';

// 3. Prompt base — forçando o GPT a começar com o termo entre aspas
$system_prompt = "Responda em português, de forma clara e objetiva. Sempre comece a resposta com o termo pesquisado entre aspas. Exemplo: \"Sapientia\" é uma palavra em latim que significa sabedoria.";

// 4. Monta payload da requisição
$payload = [
    "model" => "gpt-4o-mini",
    "messages" => [
        ["role" => "system", "content" => $system_prompt],
        ["role" => "user", "content" => $entradaUsuario]
    ],
    "temperature" => 0.2,
    "max_tokens" => 1000,
];

// 5. Faz requisição à API OpenAI
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
curl_close($ch);

// 6. Tratamento de erros
if ($err) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro CURL: ' . $err]);
    exit;
}

$respJson = json_decode($response, true);
if (!$respJson || !isset($respJson['choices'][0]['message']['content'])) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Resposta inválida da OpenAI', 'body' => $response]);
    exit;
}

$resposta = $respJson['choices'][0]['message']['content'];

// 7. Extrai o título entre aspas
preg_match('/^"([^"]+)"/', $resposta, $matches);
$tituloExtraido = $matches[1] ?? $entradaUsuario;

// 8. Salva no banco (titulo extraído + resposta)
$stmt = $pdo->prepare("INSERT INTO respostas (titulo, resposta) VALUES (?, ?)
                       ON DUPLICATE KEY UPDATE resposta = VALUES(resposta)");
$stmt->execute([$tituloExtraido, $resposta]);

// 9. Retorna resposta final
echo json_encode([
    'success' => true,
    'titulo' => $tituloExtraido,
    'reply' => $resposta,
    'fonte' => 'api'
]);
exit;
?>
