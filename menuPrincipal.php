<?php
include('./protect.php');
include('./conexao.php');
// Obtém o ID do usuário logado
$idUsuarioLogado = $_SESSION['id'];

// Chama a função contarAtendimentos
$totalAtendimentos = contarAtendimentos($idUsuarioLogado);


?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">     
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/menu.css">
        <link rel="stylesheet" href="./styles/menuPrincipal.css">
        <link rel="stylesheet" href="./styles/footer.css">
        <link rel="icon" href="./Imagens/IconeLogo.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./scripts/menubarra.js"></script>
        <title>Menu Principal</title>
    </head>
    <body>
        <!--////////--> 
        <?php include 'header.php'; ?>
        <!--////////--> 
        <main>
            <!-- classes para criação dos menus em desktop e mobile-->
            <?php include 'menu.php'; ?>
            <!--////////-->        
            <div class="conteudoMenuPrincipal">
                <div class="divBoasVindas">
                    <h2>Bem-vindo(a) ao Clinik Flow, <?php echo $_SESSION['nome'];?></h2>
                </div>
                <div class="divContainer">
                    <div class="divAtendimentos">
                        <p>Você tem <b style="color: red;"><?php echo $totalAtendimentos; ?></b> atendimentos agendados para hoje.</p><br>
                        <a href="./atendimento.php" class = "btnAtendimentos"  id="item3"><img class="btnAtendimentosImg" src="./Imagens/Agenda.png" alt="icone de agenda"></a>
                    </div>
                    <div class="divAtualizacoes" id="listaAtualizacoes">
                        <h3>Atualizações do App:</h3>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="footerLogo">
                <img src="./Imagens/Logo.png" alt="Logo do aplicativo Clinik Flow" class="Clinik">
            </div> 
        </footer> 
        <script>
            $(document).ready(function() {
                // Função para verificar atualizações
                function verificarAtualizacoes() {
                    $.ajax({
                        url: 'check_updates.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(atualizacoes) {
                            // Manipula as atualizações recebidas
                            exibirAtualizacoes(atualizacoes);
                        },
                        error: function() {
                            console.error('Erro ao verificar atualizações.');
                        }
                    });
                }

                // Função para exibir as atualizações
                function exibirAtualizacoes(atualizacoes) {
                    var listaAtualizacoes = '<h3>Atualizações Recentes:</h3><ul>';
                    
                    // Adiciona cada mensagem de commit à lista
                    atualizacoes.forEach(function(commitMessage) {
                        listaAtualizacoes += '<li>' + commitMessage + '</li>';
                    });

                    listaAtualizacoes += '</ul>';
                    $('#listaAtualizacoes').html(listaAtualizacoes);
                }

                // Verifica atualizações a cada 5 minutos (300000 milissegundos)
                setInterval(verificarAtualizacoes, 300000);
                
                // Chamar a função imediatamente ao carregar a página
                verificarAtualizacoes();
            });
        </script>
    </body>
</html>