<?php
include('./conexao.php');
include('./protect.php');

// Consulta SQL para obter todos os registros de usuários
$sql_code = "SELECT * FROM usuarios";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

// Variável para armazenar a tabela HTML
$tabelaHTML = '';

// Verificar se há registros
if ($sql_query->num_rows > 0) {
    // Iniciar a tabela HTML
    $tabelaHTML .= '<table border="1">
            <tr>
                <th>ID</th>
                <th>Nickname</th>
                <th>Nome</th>
                <th>Cargo</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CRM</th>
                <th>Especialidade</th>
            </tr>';

    // Loop através dos registros e exibir em linhas da tabela
    while ($row = $sql_query->fetch_assoc()) {
        $tabelaHTML .= '<tr>';
        $tabelaHTML .= '<td>' . $row['id'] . '</td>';
        $tabelaHTML .= '<td>' . $row['nickname'] . '</td>';
        $tabelaHTML .= '<td>' . $row['nome'] . '</td>';
        $tabelaHTML .= '<td>' . $row['cargo'] . '</td>';
        $tabelaHTML .= '<td>' . $row['email'] . '</td>';
        $tabelaHTML .= '<td>' . $row['telefone'] . '</td>';
        $tabelaHTML .= '<td>' . $row['crm'] . '</td>';
        $tabelaHTML .= '<td>' . $row['especialidade'] . '</td>';
        // Adicione mais colunas conforme necessário
        // Exemplo: echo '<td>' . $row['outra_coluna'] . '</td>';
        $tabelaHTML .= '</tr>';
    }

    // Fechar a tabela HTML
    $tabelaHTML .= '</table>';
} else {
    $tabelaHTML .= 'Nenhum usuário cadastrado.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/comum.css">
    <link rel="stylesheet" href="./styles/usuarios.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <script src="./scripts/conteudoMenu.js"></script>
    <title>Home</title>
</head>
<body>
    <div class="conteudo pagina-conteudo">
        <div id="tabelaDiv">
            <h2>Usuários</h2>
            <?php echo $tabelaHTML; ?>
            <div class="btnsTabela">
                <a href="./teste2.php" id="cadastrarUsuario">Cadastrar</a>
            </div>          
        </div>
    </div>
</body>
</html>