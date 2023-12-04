<?php
include('./conexao.php');
include('./protect.php');

// Armazena o ID_clinica do usuário logado
$idClinica = $_SESSION['ID_clinica'];
// Armazena o setor do usuário logado
$setorUsuarioLogado = $_SESSION['Setor'];
// Armazena o cargo do usuário logado
$cargoUsuarioLogado = $_SESSION['cargo'];

// Verifica se a data atual corresponde a alguma data de atendimento agendado
$dataAtual = date('Y-m-d');

// Atualiza os atendimentos para "Atrasado" se a data for menor que hoje
$sqlAtualizarAtrasados = "UPDATE atendimentos SET Situacao = 'Atrasado' WHERE Data_atendimento < '$dataAtual' AND Situacao = 'Agendado'";
$mysqli->query($sqlAtualizarAtrasados);

// Atualiza os atendimentos para "Ativo" se a data for igual a hoje
$sqlAtualizarAtivos = "UPDATE atendimentos SET Situacao = 'Ativo' WHERE Data_atendimento = '$dataAtual' AND Situacao = 'Agendado'";
$mysqli->query($sqlAtualizarAtivos);

// Verifica se foi passado um parâmetro 'status' na URL
$status = isset($_GET['status']) ? $_GET['status'] : 'Ativo';

if ($cargoUsuarioLogado == 'CHEFE_DPTO'){
    $condicaoCargo = "AND Setor = '$setorUsuarioLogado'";
} else if ($cargoUsuarioLogado == 'ESPECIALISTA'){
    $condicaoCargo = "AND Prof_responsavel = '" . $_SESSION['nome'] . "'";
} else if ($cargoUsuarioLogado == 'ADM' || $cargoUsuarioLogado == 'RECEPCIONISTA'){
    $condicaoCargo = "";
} else {
    die("Cargo de usuário não reconhecido.");
}

if($status == 'Ativo')
{

    $sql_code = "SELECT * FROM atendimentos WHERE ID_clinica = '$idClinica' $condicaoCargo AND (Situacao = '$status' OR Situacao = 'Atrasado')";
    $titulo = "Atendimentos";
    $naoEncontrado = "Nenhum atendimento encontrado!";
    $botao = "Finalizar";
}
elseif($status == "Agendado")
{
    $sql_code = "SELECT * FROM atendimentos WHERE ID_clinica = '$idClinica' $condicaoCargo AND Situacao = '$status'";
    $titulo = "Agendamentos";
    $naoEncontrado = "Nenhum agendamento encontrado!";
    $botao = "Cancelar";
}

// Executa a consulta SQL
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

// Variável para armazenar a tabela HTML
$tabelaHTML = '';

// Verificar se há registros
if ($sql_query->num_rows > 0) {
    // Iniciar a tabela HTML
    $tabelaHTML .= '<table border="1" class="tabelaPrin">
            <tr>
                <th>Situação</th>
                <th>Protocolo</th>
                <th>Nome do Paciente</th>
                <th>Serviço/Procedimento</th>
                <th>Data do atendimento</th>
                <th>Horário de Início</th>            
                <th>Profissional Responsável</th>
                <th>Risco</th>
                <th>Setor</th>
                <th>Retorno</th>
            </tr>';

    // Loop através dos registros e exibir em linhas da tabela
    while ($row = $sql_query->fetch_assoc()) {
        $dataAtendimentoFormatada = date('d/m/Y', strtotime($row['Data_atendimento']));

        $tabelaHTML .= '<tr>';
        $tabelaHTML .= '<td>' . $row['Situacao'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Protocolo'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Nome_paciente'] . '</td>';       
        $tabelaHTML .= '<td>' . $row['Servico'] . '</td>';
        $tabelaHTML .= '<td>' . $dataAtendimentoFormatada . '</td>';
        $tabelaHTML .= '<td>' . $row['Horario_inicio'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Prof_responsavel'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Risco'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Setor'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Retorno'] . '</td>';
        $tabelaHTML .= '<td><button class="editar-btn" onclick="openModalEditAtd(\'' . $row["Protocolo"] . '\')">Editar</button></td>';
        $tabelaHTML .= '<td>' . '<button class="finalizar-btnAtd" data-id="' . $row["Protocolo"] . '">'.$botao.'</button>' . '</td>';
        $tabelaHTML .= '</tr>';
    }

    // Fechar a tabela HTML
    $tabelaHTML .= '</table>';
} else {
    $tabelaHTML .= "$naoEncontrado";
}
?> 
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/menu.css">
        <link rel="stylesheet" href="./styles/atendimento.css">
        <link rel="stylesheet" href="./styles/footer.css">
        <link rel="icon" href="./Imagens/IconeLogo.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
        <script src="./scripts/menubarra.js"></script>
        <title>Atendimentos</title>
    </head>
    <body>
        <!--////////--> 
        <?php include 'header.php'; ?>
        <!--////////--> 
        <main>
            <!-- classes para criação dos menus em desktop e mobile-->
            <?php include 'menu.php'; ?>
            <!--////////--> 
            <div class="conteudoUsuarios">             
                <div id="tabelaDiv">
                    <!--<a class="btnMenu" href="./pacientes.php">Voltar</a>-->
                    <div class="btnsAtendimentos">
                        <a class="btnMenu" href="./atendimento.php?status=Ativo" id="btnAtendimentosAtivos">Atendimentos Ativos</a>
                        <a class="btnMenu" href="./atendimento.php?status=Agendado" id="btnAgendamentos">Agendamentos</a>
                    </div>
                    <h2><?php echo $titulo?></h2>
                    <div class="filtros">                      
                        <label for="searchInput">Pesquisar por protocolo ou nome: </label>
                        <input type="text" id="searchInput" name="searchInput" placeholder="Nome ou Protocolo">
                    </div>
                    <?php echo $tabelaHTML; ?>
                    <div class="btnsTabela">
                        <button onclick="openModalRegAtd()">Atender</button>
                    </div>                   
                </div>
                <!--Os modais abaixo só aparecem quando chamados pelas respectivas funções-->
                <div class="modal" id="editarAtd">
                    <div class="modal-content">
                        <a class="close-btn" onclick="closeModal()"><img src="./Imagens/close.png" alt="botão de fechar"></a>
                        <iframe src="editar_atendimento.php" width="100%" height="400"></iframe>
                    </div>
                </div>
                <div class="modal" id="cadastrarAtd">
                    <div class="modal-content">
                        <a class="close-btn" onclick="closeModal()"><img src="./Imagens/close.png" alt="botão de fechar"></a>
                        <iframe src="cadastrar_atendimento.php" width="100%" height="400"></iframe>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="footerLogo">
                <img src="./Imagens/Logo.png" alt="Logo do aplicativo Clinik Flow" class="Clinik">
            </div>
        </footer>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./scripts/funcoesModal.js"></script>
        <script src="./scripts/filtroPesquisaAtd.js"></script>
    </body>
</html>