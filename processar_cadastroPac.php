<?php
include('./protect.php');
include('./conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário
    $nome = $mysqli->real_escape_string($_POST['nome']);
    $CPF = $mysqli->real_escape_string($_POST['CPF']);
    $RG = $mysqli->real_escape_string($_POST['RG']);
    $nome_pai = $mysqli->real_escape_string($_POST['nome_pai']);
    $nome_mae = $mysqli->real_escape_string($_POST['nome_mae']);
    $RNE = $mysqli->real_escape_string($_POST['RNE']);
    $estado_civil = $mysqli->real_escape_string($_POST['estado_civil']);
    $sexo = $mysqli->real_escape_string($_POST['sexo']);
    $etnia = $mysqli->real_escape_string($_POST['etnia']);
    $nacionalidade = $mysqli->real_escape_string($_POST['nacionalidade']);
    $data_nascimento = $mysqli->real_escape_string($_POST['data_nascimento']);
    $responsavel_legal = $mysqli->real_escape_string($_POST['responsavel']);
    $telefone = $mysqli->real_escape_string($_POST['telefone']);
    $nome_emergencia = $mysqli->real_escape_string($_POST['nome_emergencia']);
    $telefone_emergencia = $mysqli->real_escape_string($_POST['telefone_emergencia']);
    $parentesco_emergencia = $mysqli->real_escape_string($_POST['parentesco_emergencia']);
    $CEP = $mysqli->real_escape_string($_POST['CEP']);
    $endereco_rua = $mysqli->real_escape_string($_POST['endereco_rua']);
    $endereco_numero = $mysqli->real_escape_string($_POST['endereco_numero']);
    $complemento = $mysqli->real_escape_string($_POST['complemento']);
    $numero_carteirinha = $mysqli->real_escape_string($_POST['carteirinha']);
    $idClinica = $_SESSION['ID_clinica'];

    // Insere os dados no banco de dados
    $sql = "INSERT INTO paciente (nome_completo, CPF, RG, nome_pai, nome_mae, RNE, estado_civil, sexo, etnia, nacionalidade, data_nascimento, responsavel_legal, telefone, nome_emergencia, telefone_emergencia, parentesco_emergencia, CEP, endereco_rua, endereco_numero, complemento, numero_carteirinha, ID_clinica) VALUES ('$nome', '$CPF', '$RG', '$nome_pai', '$nome_mae', '$RNE', '$estado_civil', '$sexo', '$etnia', '$nacionalidade', '$data_nascimento', '$responsavel_legal', '$telefone', '$nome_emergencia', '$telefone_emergencia', '$parentesco_emergencia', '$CEP', '$endereco_rua', '$endereco_numero', '$complemento', '$numero_carteirinha', '$idClinica')";

    if ($mysqli->query($sql)) {
        echo '<script>
            alert("Paciente cadastrado com sucesso!");
            window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
        </script>'; 
    } else {
        echo "Erro ao cadastrar paciente: " . $mysqli->error;
    }
}
?>
