<?php
include('./conexao.php');
include('./protect.php');

// Verifica se o ID do usuário foi fornecido
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $sql_codeFoto = "SELECT Foto FROM usuarios WHERE ID = $userId";
    $result = $mysqli->query($sql_codeFoto);

    if ($result) {
        // Obtém o caminho da imagem
        $row = $result->fetch_assoc();
        $caminhoImagem = $row['Foto'];

        // Exclui o arquivo de imagem, se existir
        if ($caminhoImagem && file_exists($caminhoImagem)) {
            unlink($caminhoImagem);
        }
    }

    // Consulta SQL para excluir o usuário com base no ID
    $sql_code = "DELETE FROM usuarios WHERE ID = $userId";

    // Executa a consulta
    if ($mysqli->query($sql_code)) {
        // A exclusão foi bem-sucedida
        echo 'Usuário com ID ' . $userId . ' foi excluído com sucesso.';
    } else {
        // Se houver um erro na exclusão
        echo 'Falha ao excluir o usuário com ID ' . $userId . ': ' . $mysqli->error;
    }
} else {
    // Se o ID do usuário não foi fornecido na solicitação
    echo 'ID de usuário não fornecido.';
}
?>
