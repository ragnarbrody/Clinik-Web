<?php
include('./protect.php');
include('./conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário
    $servico = $mysqli->real_escape_string($_POST['Servico']);
    $valor = $mysqli->real_escape_string($_POST['Valor']);
    $descricao = $mysqli->real_escape_string($_POST['Descricao']);
    $especialidade = $mysqli->real_escape_string($_POST['Especialidade']);
    $situacao = $mysqli->real_escape_string($_POST['Situacao']);
    $duracao = $mysqli->real_escape_string($_POST['Duracao_Estimada']);

    // Insere os dados no banco de dados
    $sql = "INSERT INTO servicos (Servico, Valor, Descricao, Especialidade, Situacao, Duracao_Estimada) VALUES ('$servico', '$valor', '$descricao', '$especialidade', '$situacao', '$duracao')";

    if ($mysqli->query($sql)) {
        echo '<script>
            alert("Serviço cadastrado com sucesso!");
            window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
        </script>'; 
    } else {
        echo "Erro ao cadastrar Serviço: " . $mysqli->error;
    }
}
?>
