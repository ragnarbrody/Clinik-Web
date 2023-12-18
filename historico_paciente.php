<?php
    include('./conexao.php');
    include('./protect.php');

    $pacienteId = isset($_GET['id']) ? $_GET['id'] : null;
?>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="mdlHistorico.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<!-- Bootstrap JS e dependências -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style>
    .container
    {
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
    }
</style>
<div class="container mt-4">
    <h2>Histórico de Atendimentos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Protocolo</th>
                <th>Serviço</th>
                <th>Data do Atendimento</th>
                <th>Data Finalizado</th>
                <th>Profissional Responsável</th>
                <th>Horário de Início</th>
                <th>Horário de Saída</th>
                <th>Setor</th>
                <th>Situação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Sua lógica PHP para recuperar dados do banco de dados
            $sql_code = "SELECT Protocolo, Servico, Data_atendimento, Data_finalizado, Prof_responsavel, Horario_inicio, Horario_saida, Setor, Situacao FROM atendimentos WHERE ID_paciente = $pacienteId AND (Situacao = 'Finalizado' OR Situacao = 'Cancelado')";
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

            while ($row = $sql_query->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['Protocolo']}</td>";
                echo "<td>{$row['Servico']}</td>";
                echo "<td>".date('d/m/Y', strtotime($row['Data_atendimento']))."</td>";
                echo "<td>".date('d/m/Y', strtotime($row['Data_finalizado']))."</td>";
                echo "<td>{$row['Prof_responsavel']}</td>";
                echo "<td>{$row['Horario_inicio']}</td>";
                echo "<td>{$row['Horario_saida']}</td>";
                echo "<td>{$row['Setor']}</td>";
                echo "<td>{$row['Situacao']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>