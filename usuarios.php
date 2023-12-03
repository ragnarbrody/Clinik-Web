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
                <th>Foto de Perfil</th>
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
        $tabelaHTML .= '<td>';
        // Verifica se há uma foto existente
        if (isset($row['Foto']) && !empty($row['Foto']) && file_exists($row['Foto'])) {
            $tabelaHTML .= '<img src="' . $row['Foto'] . '" alt="Foto de Perfil" class="fotoPerfil">';
        } else {
            $tabelaHTML .= 'Sem foto';
        }
        $tabelaHTML .= '</td>';
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
        <!--////////--> 
        <?php include 'header.php'; ?>
        <!--////////--> 
        <main>
            <!-- classes para criação dos menus em desktop e mobile-->
            <?php include 'menu.php'; ?>
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