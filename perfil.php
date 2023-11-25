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
        <link rel="stylesheet" href="./styles/perfil.css">
        <link rel="stylesheet" href="./styles/footer.css">
        <link rel="icon" href="./Imagens/IconeLogo.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./scripts/menubarra.js"></script>
        <title>Perfil</title>
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
            <div class="conteudoPerfil">
                <div class="containerConteudo">
                    <h2>Bem Vindo(a)!</h2>
                    <p>Nesta página você encontra seus dados de usuário:</p>
                    <div class="dados">
                        <p>seu nome é: <?php echo $_SESSION['nome'];?></p>
                        <p>seu cargo no aplicativo é: <?php echo $_SESSION['cargo'];?></p>
                        <p>seu email é: <?php echo $_SESSION['email'];?></p>
                        <p>seu nome de usuário é: <?php echo $_SESSION['apelido'];?></p>
                        <p>seu telefone é: <?php echo $_SESSION['telefone'];?></p>
                        <p>o nome da sua clinica é: <?php echo $_SESSION['Nome_clinica'];?></p>
                        <p>o endereço da sua clinica é: <?php echo $_SESSION['Logradouro'];?></p>
                        <p>o email da sua clinica é: <?php echo $_SESSION['Email_clinica'];?></p>
                        <p>a senha de app é: <?php echo $_SESSION['Senha_email'];?></p>
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