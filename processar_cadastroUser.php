<?php
include('./protect.php');
include('./conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário
    $nome = $mysqli->real_escape_string($_POST['nome']);
    $cargo = $mysqli->real_escape_string($_POST['cargo']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $telefone = $mysqli->real_escape_string($_POST['telefone']);
    $nickname = $mysqli->real_escape_string($_POST['nick']);
    $crm = $mysqli->real_escape_string($_POST['crm']);
    $especialidade = $mysqli->real_escape_string($_POST['especialidade']);
    $senha = $mysqli->real_escape_string($_POST['senha']);

    // Insere os dados no banco de dados
    $sql = "INSERT INTO usuarios (nome, cargo, email, telefone, nickname, crm, especialidade, senha) VALUES ('$nome', '$cargo', '$email', '$telefone', '$nickname', '$crm', '$especialidade', '$senha')";

    if ($mysqli->query($sql)) {
        echo '<script>
            alert("Usuário cadastrado com sucesso!");
            window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
        </script>'; 
    } else {
        echo "Erro ao cadastrar usuário: " . $mysqli->error;
    }
}
?>
