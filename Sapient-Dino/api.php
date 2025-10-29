<?php

// 1. DADOS NECESSÁRIOS
$api_key = ''; // Lembre-se de onde deve armazenar isso (segurança!)
$url = 'https://api.openai.com/v1/chat/completions';

// O JSON (corpo da requisição) que você enviará para a OpenAI
$data = array(
    'model' => 'gpt-3.5-turbo', // Ou o modelo que você preferir
    'messages' => array(
        array('role' => 'user', 'content' => 'O que é PHP?')
    ),
    'temperature' => 0.7
);

// Converte o array PHP em uma string JSON para o cURL
$json_data = json_encode($data);

// ----------------------------------------------------
// 2. INICIALIZAR
// ----------------------------------------------------
$ch = curl_init(); // Cria um novo recurso cURL

// ----------------------------------------------------
// 3. CONFIGURAR (Usando curl_setopt)
// ----------------------------------------------------

// Define a URL do endpoint
curl_setopt($ch, CURLOPT_URL, $url);

// Define que queremos o método POST
curl_setopt($ch, CURLOPT_POST, 1);

// Anexa o corpo da requisição (a string JSON)
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

// Define que o cURL deve retornar a resposta como uma string em vez de imprimi-la diretamente
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Define os HEADERS (muito importantes para a OpenAI)
$headers = array(
    'Content-Type: application/json', // Informa que o corpo é JSON
    'Authorization: Bearer ' . $api_key // Autenticação com sua chave
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


// ----------------------------------------------------
// 4. EXECUTAR
// ----------------------------------------------------
$response = curl_exec($ch);

// Verificação de erro (boa prática!)
if (curl_errno($ch)) {
    // Se houver erro de cURL, ele será exibido
    $error_msg = curl_error($ch);
    echo "Erro cURL: " . $error_msg;
}

// ----------------------------------------------------
// 5. FECHAR
// ----------------------------------------------------
curl_close($ch); // Libera os recursos do sistema

// ----------------------------------------------------
// 6. TRATAR A RESPOSTA (JSON -> Array/Objeto PHP)
// ----------------------------------------------------

// Transforma a string JSON de resposta em um objeto PHP
$api_response = json_decode($response);

// Exemplo de uso da resposta:
if (isset($api_response->choices[0]->message->content)) {
    echo "Resposta da OpenAI: " . $api_response->choices[0]->message->content;
} else {
    echo "Erro na resposta da API: ";
    print_r($api_response);
}

?>