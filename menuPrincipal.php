<?php
include('./protect.php')
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
        <title>Menu Principal</title>
    </head>
    <body>
        <header>
            <div class="Logo Icon">
                <img src="./Imagens/Logo.png" alt="Logo do aplicativo Clinik Flow" class="Clinik">
                <img src="./Imagens/Linhas.png" alt="" class="Linhas">
            </div>          
            <div class="Logo nomeSlogan">
                <img src="./Imagens/Clinik.png" alt="Nome do aplicativo Clinik Flow" class="Nome">
                <p class="Slogan">Seja bem-vindo(a) ao Clinik Flow, <?php echo $_SESSION['nome'];?></p>
            </div>     
        </header>
        <main>
            <div class="menu">
                <ul class="menuServicos">
                    <li><a href="./perfil.php" id="item0"><img src="./Imagens/iconPerfil2.png" alt="icone de usuarios" class="icons">Perfil</a></li>
                    <li><a href="./usuarios.php" id="item1"><img src="./Imagens/IconPerfil.png" alt="icone de usuarios" class="icons">Usuarios</a></li>
                    <li><a href="./pacientes.php" id="item2"><img src="./Imagens/Pacientes.png" alt="icone de pacientes" class="icons">Pacientes</a></li>
                    <li><a href="./servicos.php" id="item3"><img src="./Imagens/box.png" alt="icone de serviços" class="icons">Serviços</a></li>
                    <li><a href="#" id="item3"><img src="./Imagens/Agenda.png" alt="icone de usuarios" class="icons">Agenda</a></li>
                    <li><a href="#" id="item4"><img src="./Imagens/Financeiro.png" alt="icone de usuarios" class="icons">Financeiro</a></li>
                    <li class="btnSair no-ajax"><a href="./logout.php"><img src="./Imagens/sair.png" alt="icone de usuarios" class="icons">Sair</a></li>
                </ul>
            </div>
            <div class="conteudoMenuPrincipal">
                <div class="containerConteudo">
                    <h2>Bem Vindo(a)!</h2>
                    <p>Nesta página você encontra seus dados de usuário:</p>
                    <div class="dados">
                        <p>seu nome é: <?php echo $_SESSION['nome'];?></p>
                        <p>seu cargo no aplicativo é: <?php echo $_SESSION['cargo'];?></p>
                        <p>seu email é: <?php echo $_SESSION['email'];?></p>
                        <p>seu nome de usuário é: <?php echo $_SESSION['nickname'];?></p>
                        <p>seu telefone é: <?php echo $_SESSION['telefone'];?></p>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="footerLogo">
                <img src="./Imagens/Logo.png" alt="Logo do aplicativo Clinik Flow" class="Clinik">
            </div> 
        </footer> 
    </body>
</html>