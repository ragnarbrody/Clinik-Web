<?php
include('./protect.php');
include('./conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário
    $Servico = $mysqli->real_escape_string($_POST['Servico']);
    $ID_servico = $mysqli->real_escape_string($_POST['ID_servico']);
    $Paciente = $mysqli->real_escape_string($_POST['Paciente']);
    $ID_paciente = $mysqli->real_escape_string($_POST['ID_paciente']);
    $Prof_responsavel = $mysqli->real_escape_string($_POST['Prof_responsavel']);
    $ID_profResponsavel = $mysqli->real_escape_string($_POST['ID_profResponsavel']);
    $ID_clinica = $mysqli->real_escape_string($_POST['ID_clinica']);
    $Data_atendimento = $mysqli->real_escape_string($_POST['Data_atendimento']);
    $Horario_inicio = $mysqli->real_escape_string($_POST['Horario_inicio']);
    $Risco = $mysqli->real_escape_string($_POST['Risco']);
    $Retorno = $mysqli->real_escape_string($_POST['Retorno']);
    $CPF_paciente = $mysqli->real_escape_string($_POST['CPF_paciente']);
    $Responsavel_legal = $mysqli->real_escape_string($_POST['Responsavel_legal']);
    $Setor = $mysqli->real_escape_string($_POST['Setor']);
    $Situacao = $mysqli->real_escape_string($_POST['Situacao']);
    $Protocolo = $mysqli->real_escape_string($_POST['Protocolo']);
    // Armazena o ID_clinica do usuário logado
    $idClinica = $_SESSION['ID_clinica'];
    // Insere os dados no banco de dados
    $sql = "INSERT INTO atendimentos (Servico, ID_servico, Nome_paciente, ID_paciente, Prof_responsavel, ID_profResponsavel, ID_clinica, Data_atendimento, Horario_inicio, Risco, Retorno, CPF_paciente, Responsavel_legal, Setor, Situacao, Protocolo) VALUES ('$Servico', '$ID_servico', '$Paciente', '$ID_paciente', '$Prof_responsavel', '$ID_profResponsavel', '$ID_clinica', '$Data_atendimento', '$Horario_inicio', '$Risco', '$Retorno', '$CPF_paciente', '$Responsavel_legal', '$Setor', '$Situacao', '$Protocolo')";

    if ($mysqli->query($sql)) {
        echo '<script>
            alert("Atendimento registrado com sucesso!");
            window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
        </script>'; 
    } else {
        echo "Erro ao registrar o atendimento: " . $mysqli->error;
    }
}
?>
