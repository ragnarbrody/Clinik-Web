<?php
include('./protect.php');
include('./conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário
    $nome = $mysqli->real_escape_string($_POST['nome']);
    $nacionalidade = $mysqli->real_escape_string($_POST['nacionalidade']);
    $setor = $mysqli->real_escape_string($_POST['setor']);
    $cargo = $mysqli->real_escape_string($_POST['cargo']);
    $crm = $mysqli->real_escape_string($_POST['crm']);
    $nick = $mysqli->real_escape_string($_POST['apelido']);
    $senha = $mysqli->real_escape_string($_POST['senha']);
    $especialidade = $mysqli->real_escape_string($_POST['especialidade']);
    $cpf = $mysqli->real_escape_string($_POST['cpf']);
    $rg = $mysqli->real_escape_string($_POST['rg']);
    $data_nascimento = $mysqli->real_escape_string($_POST['data_nascimento']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $telefone = $mysqli->real_escape_string($_POST['telefone']);

    // Insere os dados no banco de dados
    $sql = "INSERT INTO usuarios (Nome, Nacionalidade, Setor, Cargo, CRM, Apelido, Senha, Especialidade, CPF, RG, Data_nascimento, Email, Telefone) VALUES ('$nome', '$nacionalidade', '$setor', '$cargo', '$crm', '$nick', '$senha', '$especialidade', '$cpf', '$rg', '$data_nascimento', '$email', '$telefone')";

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
