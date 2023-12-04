<?php
include('./conexao.php');
include('./protect.php');

// Armazena o ID_clinica do usuário logado
$idClinica = $_SESSION['ID_clinica'];
// Armazena o setor do usuário logado
$setorUsuarioLogado = $_SESSION['Setor'];
// Armazena o cargo do usuário logado
$cargoUsuarioLogado = $_SESSION['cargo'];
// Consulta SQL
if ($cargoUsuarioLogado == 'CHEFE_DPTO'){
    $sql_code = "SELECT * FROM servicos WHERE ID_clinica = '$idClinica' AND Especialidade = '$setorUsuarioLogado'";
} else if ($cargoUsuarioLogado == 'ADM'){
    $sql_code = "SELECT * FROM servicos WHERE ID_clinica = '$idClinica'";
}

$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

// Variável para armazenar a tabela HTML
$tabelaHTML = '';

// Verificar se há registros
if ($sql_query->num_rows > 0) {
    // Iniciar a tabela HTML
    $tabelaHTML .= '<table border="1" class="tabelaPrin">
            <tr>
                <th>ID</th>
                <th>Serviço</th>
                <th>Valor</th>
                <th>Descrição</th>
                <th>Especialidade</th>
                <th>Situacao</th>
                <th>Duração Estimada</th>
            </tr>';

    // Loop através dos registros e exibir em linhas da tabela
    while ($row = $sql_query->fetch_assoc()) {
        $tabelaHTML .= '<tr>';
        $tabelaHTML .= '<td>' . $row['ID'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Servico'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Valor'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Descricao'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Especialidade'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Situacao'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Duracao_Estimada'] . '</td>';
        $tabelaHTML .= '<td><button class="editar-btn" onclick="openModalEditServ(' . $row["ID"] . ')">Editar</button></td>';
        $tabelaHTML .= '<td>' . '<button class="excluir-btnServ" data-id="' . $row["ID"] . '">Excluir</button>' . '</td>';
        // Deixei aqui pra adicionar mais colunas se precisar
        $tabelaHTML .= '</tr>';
    }

    // Fechar a tabela HTML
    $tabelaHTML .= '</table>';
} else {
    $tabelaHTML .= '<br>Nenhum serviço cadastrado.';
}
?> 
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/menu.css">
        <link rel="stylesheet" href="./styles/servicos.css">
        <link rel="stylesheet" href="./styles/footer.css">
        <link rel="icon" href="./Imagens/IconeLogo.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./scripts/menubarra.js"></script>
        <title>Serviços</title>
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
                <div id="tabelaDiv" class="tabelaDiv">
                    <?php if ($_SESSION['cargo'] == 'ADM') : ?>
                        <h2>Serviços da clinica</h2>
                    <?php endif; ?>
                    <?php if ($_SESSION['cargo'] == 'CHEFE_DPTO') : ?>
                        <h2>Serviços do seu Setor</h2>
                    <?php endif; ?>
                    <div class="filtros">
                        <label for="searchInput">Pesquisar por ID ou Serviço: </label>
                        <input type="text" id="searchInput" name="searchInput" placeholder="ID ou Nome"><br>
                    </div>
                    <?php echo $tabelaHTML; ?>
                    <div class="btnsTabela">
                        <button onclick="openModalRegServ()">Cadastrar</button>
                    </div>
                </div>
                <!--Os modais abaixo só aparecem quando chamados pelas respectivas funções-->
                <div class="modal">
                    <div class="modal-content" id="editarUser">
                        <a class="close-btn" onclick="closeModal()"><img src="./Imagens/close.png" alt="botão de fechar"></a>
                        <iframe src="editar_servico.php" width="100%" height="400"></iframe>
                    </div>
                </div>
                <div class="modal" id="cadastrarServ">
                    <div class="modal-content">
                        <a class="close-btn" onclick="closeModal()"><img src="./Imagens/close.png" alt="botão de fechar"></a>
                        <iframe src="cadastrar_servico.php" width="100%" height="400"></iframe>
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
        <script src="./scripts/filtroPesquisaServ.js"></script>
    </body>
</html>