<?php
include('./conexao.php');
include('./protect.php');

// Obtém a data de 15 dias atrás a partir de hoje
$data_limite = date('Y-m-d', strtotime('-15 days'));
// Armazena o setor do usuário logado
$setorUsuarioLogado = $_SESSION['Setor'];
// Armazena o cargo do usuário logado
$cargoUsuarioLogado = $_SESSION['cargo'];

if($cargoUsuarioLogado == 'ADM')
{
    $query = "SELECT DATE(Data_finalizado) AS data_finalizado, SUM(valorServico) AS total_valor_servico 
          FROM atendimentos 
          WHERE Situacao = 'Finalizado' AND DATE(Data_finalizado) >= '$data_limite'
          GROUP BY data_finalizado
          ORDER BY data_finalizado";
    $tituloGrafico = "Lucro por Dia";
}
else if ($cargoUsuarioLogado == 'CHEFE_DPTO')
{
    $query = "SELECT DATE(Data_finalizado) AS data_finalizado, SUM(valorServico) AS total_valor_servico 
    FROM atendimentos 
    WHERE Situacao = 'Finalizado' AND Setor = '$setorUsuarioLogado' AND DATE(Data_finalizado) >= '$data_limite'
    GROUP BY data_finalizado
    ORDER BY data_finalizado";
    $tituloGrafico = "Lucro por Dia de " . $setorUsuarioLogado;
}


$result = mysqli_query($mysqli, $query);

$valores = array();
$datas = array();
while ($row = mysqli_fetch_assoc($result)) {
    // Formata a data para o formato d/m/Y
    $data_formatada = date('d/m/Y', strtotime($row['data_finalizado']));

    $datas[] = $data_formatada;
    $valores[] = $row['total_valor_servico'];
}
?> 
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/menu.css">
        <link rel="stylesheet" href="./styles/financeiro.css">
        <link rel="stylesheet" href="./styles/footer.css">
        <link rel="icon" href="./Imagens/IconeLogo.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/cf6fa412bd.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="./scripts/menubarra.js"></script>
        <title>Financeiro</title>
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
                <canvas id="lucroChart" width="400" height="200"></canvas>
                <button id="exportButton">Exportar Gráfico</button>
            </div>
        </main>
        <footer>
            <div class="footerLogo">
                <img src="./Imagens/Logo.png" alt="Logo do aplicativo Clinik Flow" class="Clinik">
            </div>
        </footer>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var ctx = document.getElementById('lucroChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($datas); ?>,
                        datasets: [{
                            label: <?php echo json_encode($tituloGrafico); ?>,
                            data: <?php echo json_encode($valores); ?>,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
                // Adiciona a funcionalidade de exportação para Excel
                document.getElementById('exportButton').addEventListener('click', function() {
                    // Cria um novo livro de Excel
                    var wb = XLSX.utils.book_new();
                    // Adiciona uma nova planilha ao livro do excel, que são as worksheets
                    var ws = XLSX.utils.aoa_to_sheet([<?php echo json_encode($datas); ?>, <?php echo json_encode($valores); ?>]);
                    // Adiciona a planilha ao livro
                    XLSX.utils.book_append_sheet(wb, ws, 'LucroPorDia');
                    // Converte o livro para um buffer
                    var buf = XLSX.write(wb, { bookType: 'xls', type: 'array' });
                    // Cria um blob a partir do buffer
                    var blob = new Blob([buf], { type: 'application/vnd.ms-excel' });
                    // Cria uma URL do blob e cria um link de download
                    var url = URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = <?php echo json_encode($tituloGrafico); ?> + '.xls';
                    document.body.appendChild(a);
                    a.click();

                    // Remove o link após o download pra não entrar em loop e crashar o site
                    document.body.removeChild(a);
                    URL.revokeObjectURL(url);
                });
            });
        </script>
    </body>
</html>