<?php
include('./conexao.php');
include('./protect.php');

// Verifica se o ID do usuário foi fornecido
if (isset($_GET['ID'])) {
    $pacId = $_GET['ID'];

    // Consulta SQL para excluir o usuário com base no ID
    $sql_code = "DELETE FROM paciente WHERE ID = $pacId";
    
    // Executa a consulta
    if ($mysqli->query($sql_code)) {
        // A exclusão foi bem-sucedida
        echo 'Paciente com ID ' . $pacId . ' foi excluído com sucesso.';
    } else {
        // Se houver um erro na exclusão
        echo 'Falha ao excluir o paciente com ID ' . $pacId . ': ' . $mysqli->error;
    }
} else {
    // Se o ID do usuário não foi fornecido na solicitação
    echo 'ID de paciente não fornecido.';
}
?>
