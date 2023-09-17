<?php
include('./protect.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/comum.css">
    <link rel="stylesheet" href="./styles/home.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <script src="./scripts/conteudoMenu.js"></script>
    <title>Home</title>
</head>
<body>
    <div class="conteudo pagina-conteudo">
        <div class="fundoConteudo">
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
</body>
</html>