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
        <!--////////--> 
        <?php include 'header.php'; ?>
        <!--////////--> 
        <main>
            <!-- classes para criação dos menus em desktop e mobile-->
            <?php include 'menu.php'; ?>
            <!--////////--> 
            <div class="conteudoPerfil">
                <div class="containerConteudo">
                    <div class="conjDados">
                        <?php if (isset($_SESSION['Foto'])) : ?>
                            <img src="<?php echo $_SESSION['Foto']; ?>" alt="Foto de Perfil" class="fotoPerfil">
                        <?php else : ?>
                            <img src="./Imagens/fotosPerfil/iconPerfilPdr.png" alt="Foto de Perfil" class="fotoPerfil">
                        <?php endif; ?>
                        <div class="dadosFoto">
                            <p class="campos">Nome:</p><?php echo empty($_SESSION['nome']) ? "[SEM INFO]" : $_SESSION['nome'];?><br>
                            <p class="campos">Data de Nascimento:</p><?php echo empty($_SESSION['Data_nascimento']) ? "[SEM INFO]" : date("d/m/Y", strtotime($_SESSION['Data_nascimento']));?><br>
                            <p class="campos">CPF:</p><?php echo empty($_SESSION['CPF']) ? "[SEM INFO]" : $_SESSION['CPF'];?><br>
                            <p class="campos">RG:</p><?php echo empty($_SESSION['RG']) ? "[SEM INFO]" : $_SESSION['RG'];?><br>
                        </div>
                    </div>
                    <div class="conjDados">
                        <div class="dados">
                            <p class="campos">Cargo:</p><?php echo empty($_SESSION['cargo']) ? "[SEM INFO]" : $_SESSION['cargo'];?><br>
                            <p class="campos">Email:</p><?php echo empty($_SESSION['email']) ? "[SEM INFO]" : $_SESSION['email'];?><br>
                            <p class="campos">Apelido:</p><?php echo empty($_SESSION['apelido']) ? "[SEM INFO]" : $_SESSION['apelido'];?><br>
                            <p class="campos">Telefone:</p><?php echo empty($_SESSION['telefone']) ? "[SEM INFO]" : $_SESSION['telefone'];?><br>
                        </div>
                        <div class="dados">
                            <p class="campos">CRM:</p><?php echo empty($_SESSION['crm']) ? "[SEM INFO]" : $_SESSION['crm'];?><br>
                            <p class="campos">Especialidade:</p><?php echo empty($_SESSION['especialidade']) ? "[SEM INFO]" : $_SESSION['especialidade'];?><br>
                            <p class="campos">Nacionalidade:</p><?php echo empty($_SESSION['Nacionalidade']) ? "[SEM INFO]" : $_SESSION['Nacionalidade'];?><br>
                            <p class="campos">Setor:</p><?php echo empty($_SESSION['Setor']) ? "[SEM INFO]" : $_SESSION['Setor'];?><br>
                        </div>
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