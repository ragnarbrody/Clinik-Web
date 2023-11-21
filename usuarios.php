<?php
include('./conexao.php');
include('./protect.php');

// Armazena o ID_clinica do usuário logado
$idClinica = $_SESSION['ID_clinica'];
// Consulta SQL para obter todos os registros de usuários
$sql_code = "SELECT * FROM usuarios WHERE ID_clinica = '$idClinica'";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

// Variável para armazenar a tabela HTML
$tabelaHTML = '';

// Verificar se há registros
if ($sql_query->num_rows > 0) {
    // Iniciar a tabela HTML
    $tabelaHTML .= '<table border="1" class="tabelaPrin">
            <tr>
                <th>ID</th>
                <th>Apelido</th>
                <th>Email</th>
                <th>Nome</th>
                <th>Setor</th>
                <th>Cargo</th>
                <th>CRM ou NF</th>
                <th>Área de atuação/Especialidade</th>
                <th>CPF</th>
                <th>Telefone</th>
            </tr>';

    // Loop através dos registros e exibir em linhas da tabela
    while ($row = $sql_query->fetch_assoc()) {
        $tabelaHTML .= '<tr>';
        $tabelaHTML .= '<td>' . $row['ID'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Apelido'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Email'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Nome'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Setor'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Cargo'] . '</td>';
        $tabelaHTML .= '<td>' . $row['CRM'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Especialidade'] . '</td>';
        $tabelaHTML .= '<td>' . $row['CPF'] . '</td>';
        $tabelaHTML .= '<td>' . $row['Telefone'] . '</td>';
        $tabelaHTML .= '<td><button class="editar-btn" onclick="openModalEdit(' . $row["ID"] . ')">Editar</button></td>';
        $tabelaHTML .= '<td>' . '<button class="excluir-btnUser" data-id="' . $row["ID"] . '">Excluir</button>' . '</td>';
        // Deixei aqui pra adicionar mais colunas se precisar
        $tabelaHTML .= '</tr>';
    }

    // Fechar a tabela HTML
    $tabelaHTML .= '</table>';
} else {
    $tabelaHTML .= 'Nenhum usuário cadastrado.';
}
?> 
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/menu.css">
        <link rel="stylesheet" href="./styles/usuarios.css">
        <link rel="stylesheet" href="./styles/footer.css">
        <link rel="icon" href="./Imagens/IconeLogo.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./scripts/menubarra.js"></script>
        <title>Usuarios</title>
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
            <!-- classes para criação dos menus em desktop e mobile-->
            <nav  class="nav-bar">
                <div class="menu">
                    <ul class="menuServicos">
                        <li class="nav-item"><a href="./perfil.php" class = "nav-link" id="item0"><img src="./Imagens/iconPerfil2.png" alt="icone de usuarios" class="icons">Perfil</a></li>
                        <li class="nav-item"><a href="./usuarios.php" class = "nav-link"  id="item1"><img src="./Imagens/IconPerfil.png" alt="icone de usuarios" class="icons">Usuarios</a></li>
                        <li class="nav-item"><a href="./pacientes.php" class = "nav-link"  id="item2"><img src="./Imagens/Pacientes.png" alt="icone de pacientes" class="icons">Pacientes</a></li>
                        <li class="nav-item"><a href="./servicos.php" class = "nav-link"  id="item3"><img src="./Imagens/box.png" alt="icone de serviços" class="icons">Serviços</a></li>
                        <li class="nav-item"><a href="./atendimento.php" class = "nav-link"  id="item3"><img src="./Imagens/Agenda.png" alt="icone de usuarios" class="icons">Agenda/Atendimento</a></li>
                        <li class="nav-item"><a href="#" class = "nav-link"  id="item4"><img src="./Imagens/Financeiro.png" alt="icone de usuarios" class="icons">Financeiro</a></li>
                        <li class="nav-item" class="btnSair no-ajax"><a href="./logout.php" class = "nav-link" ><img src="./Imagens/sair.png" alt="icone de usuarios" class="icons">Sair</a></li>
                    </ul>
                </div>
    
                
                <div class="mobile-menu-icon">
                    <button onclick="menuShow()"><img class="icon" src="./Imagens/burguer.png" alt=""></button>
                </div>
            </nav>

            <div class = "mobile-menu">
                <ul class="menuServicos">
                    <li class="nav-item"><a href="./perfil.php" class = "nav-link" id="item0"><img src="./Imagens/iconPerfil2.png" alt="icone de usuarios" class="icons">Perfil</a></li>
                    <li class="nav-item"><a href="./usuarios.php" class = "nav-link"  id="item1"><img src="./Imagens/IconPerfil.png" alt="icone de usuarios" class="icons">Usuarios</a></li>
                    <li class="nav-item"><a href="./pacientes.php" class = "nav-link"  id="item2"><img src="./Imagens/Pacientes.png" alt="icone de pacientes" class="icons">Pacientes</a></li>
                    <li class="nav-item"><a href="./servicos.php" class = "nav-link"  id="item3"><img src="./Imagens/box.png" alt="icone de serviços" class="icons">Serviços</a></li>
                    <li class="nav-item"><a href="./atendimento.php" class = "nav-link"  id="item3"><img src="./Imagens/Agenda.png" alt="icone de usuarios" class="icons">Agenda/Atendimento</a></li>
                    <li class="nav-item"><a href="#" class = "nav-link"  id="item4"><img src="./Imagens/Financeiro.png" alt="icone de usuarios" class="icons">Financeiro</a></li>
                    <li class="nav-item" class="btnSair no-ajax"><a href="./logout.php" class = "nav-link" ><img src="./Imagens/sair.png" alt="icone de usuarios" class="icons">Sair</a></li>
                </ul>
            </div>   
            <!--////////--> 
            <div class="conteudoUsuarios">
                <div id="tabelaDiv">
                    <h2>Usuários</h2>
                    <?php echo $tabelaHTML; ?>
                    <div class="btnsTabela">
                        <button onclick="openModalReg()">Cadastrar</button>
                    </div>
                </div>
                <!--Os modais abaixo só aparecem quando chamados pelas respectivas funções-->
                <div class="modal">
                    <div class="modal-content" id="editarUser">
                        <span class="close-btn" onclick="closeModal()">&times;</span>
                        <iframe src="editar_usuario.php" width="100%" height="400"></iframe>
                    </div>
                </div>
                <div class="modal" id="cadastrarUser">
                    <div class="modal-content">
                        <span class="close-btn" onclick="closeModal()">&times;</span>
                        <iframe src="cadastrar_usuario.php" width="100%" height="400"></iframe>
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