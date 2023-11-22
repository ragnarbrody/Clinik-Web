<?php
include('./conexao.php');
include('./protect.php');

// Verifica se o ID do usuário foi fornecido
if (isset($_GET['Protocolo'])) {
    $prtAtendimento = $_GET['Protocolo'];

    // Consulta SQL para excluir o usuário com base no ID
    $sql_code = "UPDATE atendimentos SET Situacao = 'Finalizado' WHERE Protocolo = $prtAtendimento";
    
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
