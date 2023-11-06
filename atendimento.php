<?php
include('./conexao.php');
include('./protect.php');

// Armazena o ID_clinica do usuário logado
$idClinica = $_SESSION['ID_clinica'];
// Consulta SQL para obter todos os registros de atendimentos relacionados à mesma clínica e com Situacao = 'Ativo'
$sql_code = "SELECT * FROM atendimentos WHERE ID_clinica = '$idClinica' AND Situacao = 'Ativo'";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

// Variável para armazenar a tabela HTML
$tabelaHTML = '';

// Verificar se há registros
if ($sql_query->num_rows > 0) {
    // Iniciar a tabela HTML
    $tabelaHTML .= '<table border="1">
            <tr>
                <th>Protocolo</th>
                <th>Nome do Paciente</th>
                <th>CPF do Paciente</th>
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
        $tabelaHTML .= '<tr>';
        $tabelaHTML .= '<td>' . $row['Protocolo'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Nome_paciente'] . '</td>';
        $tabelaHTML .= '<td>' . $row['CPF_paciente'] . '</td>';       
        $tabelaHTML .= '<td>' . $row['Servico'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Data_atendimento'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Prof_responsavel'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Risco'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Setor'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Retorno'] . '</td>';
        $tabelaHTML .= '<td><button class="editar-btn" onclick="openModalEditAtd(' . $row["Protocolo"] . ')">Editar</button></td>';
        $tabelaHTML .= '<td>' . '<button class="excluir-btnAtd" data-id="' . $row["Protocolo"] . '">Excluir</button>' . '</td>';
        // Deixei aqui pra adicionar mais colunas se precisar
        $tabelaHTML .= '</tr>';
    }

    // Fechar a tabela HTML
    $tabelaHTML .= '</table>';
} else {
    $tabelaHTML .= 'Nenhum atendimento registrado.';
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <title>Atendimentos</title>
    </head>
    <body>
        <header>
            <div class="Logo Icon">
                <img src="./Imagens/Logo.png" alt="Logo do aplicativo Clinik Flow" class="Clinik">
                <img src="./Imagens/Linhas.png" alt="" class="Linhas">
            </div>
            <div class="Logo nomeSlogan">
                <img src="./Imagens/Clinik.png" alt="Nome do aplicativo Clinik Flow" class="Nome">
                <p class="Slogan">Seja bem-vindo(a) ao Clinik Flow, <?php echo $_SESSION['nome']; ?></p>
            </div>
        </header>
        <main>
            <div class="menu">
                <ul class="menuServicos">
                    <li><a href="./perfil.php" id="item0"><img src="./Imagens/iconPerfil2.png" alt="icone de usuarios" class="icons">Perfil</a></li>
                    <li><a href="./usuarios.php" id="item1"><img src="./Imagens/IconPerfil.png" alt="icone de usuarios" class="icons"> Usuarios</a></li>
                    <li><a href="./pacientes.php" id="item2"><img src="./Imagens/Pacientes.png" alt="icone de pacientes" class="icons">Pacientes</a></li>
                    <li><a href="./servicos.php" id="item3"><img src="./Imagens/box.png" alt="icone de serviços" class="icons">Serviços</a></li>
                    <li><a href="#" id="item3"><img src="./Imagens/Agenda.png" alt="icone de usuarios" class="icons">Agenda</a></li>
                    <li><a href="#" id="item4"><img src="./Imagens/Financeiro.png" alt="icone de usuarios" class="icons">Financeiro</a></li>
                    <li class="btnSair no-ajax"><a href="./logout.php"><img src="./Imagens/sair.png" alt="icone de usuarios" class="icons">Sair</a></li>
                </ul>
            </div>
            <div class="conteudoUsuarios">             
                <div id="tabelaDiv">
                    <a class="btnMenu" href="./pacientes.php">Voltar</a>
                    <h2>Atendimentos</h2>
                    <?php echo $tabelaHTML; ?>
                    <div class="btnsTabela">
                        <button onclick="openModalRegAtd()">Atender</button>
                    </div>                   
                </div>
                <!--Os modais abaixo só aparecem quando chamados pelas respectivas funções-->
                <div class="modal">
                    <div class="modal-content" id="editarAtd">
                        <span class="close-btn" onclick="closeModal()">&times;</span>
                        <iframe src="editar_atendimento.php" width="100%" height="400"></iframe>
                    </div>
                </div>
                <div class="modal" id="cadastrarAtd">
                    <div class="modal-content">
                        <span class="close-btn" onclick="closeModal()">&times;</span>
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
        <script src="./scripts/funcoesModal.js"></script>
    </body>
</html>