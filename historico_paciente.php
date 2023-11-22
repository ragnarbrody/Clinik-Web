<?php
include('./conexao.php');
include('./protect.php');

// Verifica se o parâmetro ID foi passado na URL
if (isset($_GET['id'])) {
    $pacienteId = $_GET['id'];

    // Consulta SQL para obter os atendimentos finalizados para o paciente com base no ID fornecido
    $sql_code = "SELECT * FROM atendimentos WHERE ID_paciente = $pacienteId AND Situacao = 'Finalizado'";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    // Variável para armazenar a tabela HTML
    $tabelaHTML = '';

    // Verificar se há registros
    if ($sql_query->num_rows > 0) {
        // Iniciar a tabela HTML
        $tabelaHTML .= '<table border="1" class="tabelaPrin">
                <tr>
                    <th>Protocolo</th>
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
            $tabelaHTML .= '<td>' . $row['Servico'] . '</td>';
            $tabelaHTML .= '<td>' . $row['Data_atendimento'] . '</td>';
            $tabelaHTML .= '<td>' . $row['Horario_inicio'] . '</td>';
            $tabelaHTML .= '<td>' . $row['Prof_responsavel'] . '</td>';
            $tabelaHTML .= '<td>' . $row['Risco'] . '</td>';
            $tabelaHTML .= '<td>' . $row['Setor'] . '</td>';
            $tabelaHTML .= '<td>' . $row['Retorno'] . '</td>';
            $tabelaHTML .= '</tr>';
        }

        // Fechar a tabela HTML
        $tabelaHTML .= '</table>';
    } else {
        $tabelaHTML .= "Nenhum atendimento finalizado encontrado para este paciente!";
    }
} else {
    $tabelaHTML .= 'ID do paciente não fornecido.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles/modal.css">
        <link rel="icon" href="./Imagens/IconeLogo.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <title>Histórico</title>
    </head>
    <body>
        <main>
            <div class="conteudoUsuarios">             
                <div id="tabelaDiv">
                    <h2>Histórico</h2>
                    <div class="filtros">                      
                        <label for="searchInput">Pesquisar por protocolo ou data: </label>
                        <input type="text" id="searchInput" name="searchInput" placeholder="Data ou Protocolo">
                    </div>
                    <?php echo $tabelaHTML; ?>                 
                </div>
            </div>
        </main>
    </body>
</html>