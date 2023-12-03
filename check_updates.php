<?php
// Token de acesso pessoal do GitHub
$token = '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';

// Repositório no GitHub
$owner = 'ragnarbrody';
$repo = 'Clinik-Web';

// URL da API do GitHub para obter os últimos commits
$url = "https://api.github.com/repos/$owner/$repo/commits?per_page=2";

// Configuração da requisição à API
$options = [
    'http' => [
        'header' => "Authorization: Bearer $token",
        'user_agent' => 'PHP'
    ]
];

$context = stream_context_create($options);

// Faz a requisição à API do GitHub
$response = file_get_contents($url, false, $context);

// Verifica se a resposta foi bem-sucedida
if ($response === FALSE) {
    die('Erro ao obter os commits do GitHub.');
}

// Decodifica a resposta JSON
$commits = json_decode($response, true);

// Extraindo informações relevantes dos commits
$commitMessages = [];
foreach ($commits as $commit) {
    $messageParts = explode('-', $commit['commit']['message']);
    $formattedMessage = '<strong>' . trim($messageParts[0]) . '</strong><ul>';
    
    // Adiciona cada parte após "-" à lista
    for ($i = 1; $i < count($messageParts); $i++) {
        $formattedMessage .= '<li>' . trim($messageParts[$i]) . '</li>';
    }

    $formattedMessage .= '</ul><br>';
    $commitMessages[] = $formattedMessage;
}

// Retorna os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($commitMessages);
?>