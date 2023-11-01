<?php
include('./conexao.php');
include('./protect.php');

// Verifica se o ID do usuário foi fornecido
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Consulta SQL para excluir o usuário com base no ID
    $sql_code = "DELETE FROM servicos WHERE ID = $userId";
    
    // Executa a consulta
    if ($mysqli->query($sql_code)) {
        // A exclusão foi bem-sucedida
        echo 'Serviço com ID ' . $userId . ' foi excluído com sucesso.';
    } else {
        // Se houver um erro na exclusão
        echo 'Falha ao excluir o serviço com ID ' . $userId . ': ' . $mysqli->error;
    }
} else {
    // Se o ID do serviço não foi fornecido na solicitação
    echo 'ID de serviço não fornecido.';
}
?>
