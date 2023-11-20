<?php
include('./conexao.php');
include('./protect.php');

// Armazena o ID_clinica do usuário logado
$idClinica = $_SESSION['ID_clinica'];

// Define a data atual no formato do seu banco de dados (substitua isso pelo formato real que você está usando)
$dataAtual = date('Y-m-d');

// Consulta SQL para obter os atendimentos ativos na data de hoje
$sql_code = "SELECT * FROM atendimentos WHERE ID_clinica = '$idClinica' AND Situacao = 'Ativo' AND Data_atendimento <= '$dataAtual'";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

// Variável para armazenar a tabela HTML
$tabelaHTML = '';

// Verificar se há registros
if ($sql_query->num_rows > 0) {
    // Iniciar a tabela HTML
    $tabelaHTML .= '<table border="1">
            <tr>
                <th>Protocolo</th>
                <th>ID Paciente</th>
                <th>Nome do Paciente</th>
                <th>ID Serviço</th>
                <th>Serviço/Procedimento</th>
                <th>Data do atendimento</th>
                <th>Horário de Início</th> 
                <th>ID_profResponsavel </th>            
                <th>Profissional Responsável</th>
                <th>Risco</th>
                <th>Setor</th>
                <th>Retorno</th>
            </tr>';

    // Loop através dos registros e exibir em linhas da tabela
    while ($row = $sql_query->fetch_assoc()) {
        $tabelaHTML .= '<tr>';
        $tabelaHTML .= '<td>' . $row['Protocolo'] . '</td>';
        $tabelaHTML .= '<td>' . $row['ID_paciente'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Nome_paciente'] . '</td>';       
        $tabelaHTML .= '<td>' . $row['ID_servico'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Servico'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Data_atendimento'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Horario_inicio'] . '</td>';
        $tabelaHTML .= '<td>' . $row['ID_profResponsavel'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Prof_responsavel'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Risco'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Setor'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Retorno'] . '</td>';
        $tabelaHTML .= '<td><button class="editar-btn" onclick="openModalEditAtd(' . $row["Protocolo"] . ')">Editar</button></td>';
        $tabelaHTML .= '<td>' . '<button class="excluir-btnAtd" data-id="' . $row["Protocolo"] . '">Excluir</button>' . '</td>';
        $tabelaHTML .= '</tr>';
    }

    // Fechar a tabela HTML
    $tabelaHTML .= '</table>';
} else {
    $tabelaHTML .= 'Nenhum atendimento ativo registrado para hoje.';
}

?>             
    <div id="tabelaDiv">
        <!--<a class="btnMenu" href="./pacientes.php">Voltar</a>-->
        <div class="btnsAtendimentos">
            <a class="btnMenu" href="#" id="btnAtendimentosAtivos">Atendimentos Ativos</a>
            <a class="btnMenu" href="#">Agendamentos</a>
        </div>
        <h2>Atendimentos</h2>
        <?php echo $tabelaHTML; ?>
        <div class="btnsTabela">
            <button onclick="openModalRegAtd()">Atender</button>
        </div>                   
    </div>