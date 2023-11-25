<?php
include('./conexao.php');
include('./protect.php');

// Verifica se o ID do usuário foi fornecido
if (isset($_GET['Protocolo'])) {
    $prtAtendimento = $_GET['Protocolo'];
    // Defina o fuso horário
    date_default_timezone_set('America/Sao_Paulo');
    // Obtenha a data e hora atuais
    $dataAtual = date('Y-m-d');
    $horaAtual = date('H:i:s');

    // Consulta SQL para atualizar os campos desejados
    $sql_code = "UPDATE atendimentos 
                SET Situacao = 'Finalizado', 
                    Horario_saida = '$horaAtual', 
                    Data_finalizado = '$dataAtual' 
                WHERE Protocolo = $prtAtendimento";
    
    // Executa a consulta
    if ($mysqli->query($sql_code)) {
        // A exclusão foi bem-sucedida
        echo 'Atendimento de protocolo: ' . $prtAtendimento . ' foi finalizado com sucesso.';
    } else {
        // Se houver um erro na exclusão
        echo 'Falha ao finalizar o atendimento com protocolo ' . $prtAtendimento . ': ' . $mysqli->error;
    }
} else {
    // Se o ID do usuário não foi fornecido na solicitação
    echo 'Protocolo de atendimento não fornecido.';
}
?>
