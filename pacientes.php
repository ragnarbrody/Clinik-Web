<?php
include('./conexao.php');
include('./protect.php');

// Consulta SQL para obter todos os registros de usuários
$sql_code = "SELECT * FROM paciente";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

// Variável para armazenar a tabela HTML
$tabelaHTML = '';

// Verificar se há registros
if ($sql_query->num_rows > 0) {
    // Iniciar a tabela HTML
    $tabelaHTML .= '<table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>RNE</th>
                <th>Nome da Mãe</th>              
                <th>Sexo</th>
                <th>Etnia</th>
                <th>Data de Nascimento</th>
                <th>Telefone</th>
                <th>Carteira de Saúde</th>
                <th>Protocolo</th>
            </tr>';

    // Loop através dos registros e exibir em linhas da tabela
    while ($row = $sql_query->fetch_assoc()) {
        $tabelaHTML .= '<tr>';
        $tabelaHTML .= '<td>' . $row['ID'] . '</td>';
        $tabelaHTML .= '<td>' . $row['nome_completo'] . '</td>';
        $tabelaHTML .= '<td>' . $row['CPF'] . '</td>';
        $tabelaHTML .= '<td>' . $row['RNE'] . '</td>';
        $tabelaHTML .= '<td>' . $row['nome_mae'] . '</td>';
        $tabelaHTML .= '<td>' . $row['sexo'] . '</td>';
        $tabelaHTML .= '<td>' . $row['etnia'] . '</td>';
        $tabelaHTML .= '<td>' . $row['data_nascimento'] . '</td>';
        $tabelaHTML .= '<td>' . $row['telefone'] . '</td>';
        $tabelaHTML .= '<td>' . $row['numero_carteirinha'] . '</td>';
        $tabelaHTML .= '<td>' . $row['protocolo_atendimento'] . '</td>';
        $tabelaHTML .= '<td><a class="perfil-btn" href="./perfil_paciente.php?id=' . $row["ID"] . '">Perfil</a></td>';
        $tabelaHTML .= '<td><button class="editar-btn" onclick="openModalEditPac(' . $row["ID"] . ')">Editar</button></td>';
        $tabelaHTML .= '<td><button class="excluir-btnPac" data-id="' . $row["ID"] . '">Excluir</button>' . '</td>';
        // Deixei aqui pra adicionar mais colunas se precisar
        $tabelaHTML .= '</tr>';
    }

    // Fechar a tabela HTML
    $tabelaHTML .= '</table>';
} else {
    $tabelaHTML .= 'Nenhum paciente cadastrado.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/menu.css">
        <link rel="stylesheet" href="./styles/pacientes.css">
        <link rel="stylesheet" href="./styles/footer.css">
        <link rel="icon" href="./Imagens/IconeLogo.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <title>Pacientes</title>
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
            <div class="conteudoPacientes">
                <div id="tabelaDiv">
                    <h2>Pacientes</h2>
                    <label for="searchInput">Pesquisar por nome ou CPF: </label>
                    <input type="text" id="searchInput" name="searchInput" placeholder="Nome ou CPF">
                    <?php echo $tabelaHTML; ?>
                    <div class="btnsTabela">
                        <button onclick="openModalRegPac()">Cadastrar</button>
                    </div>
                </div>
                <!--Os modais abaixo só aparecem quando chamados pelas respectivas funções-->
                <div class="modal">
                    <div class="modal-content" id="editarPaciente">
                        <span class="close-btn" onclick="closeModal()">&times;</span>
                        <iframe src="editar_paciente.php" width="100%" height="400"></iframe>
                    </div>
                </div>
                <div class="modal" id="cadastrarPac">
                    <div class="modal-content">
                        <span class="close-btn" onclick="closeTesteModal()">&times;</span>
                        <iframe src="cadastrar_paciente" width="100%" height="400"></iframe>
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
        <script src="./scripts/filtroPesquisa.js"></script>
    </body>
</html>