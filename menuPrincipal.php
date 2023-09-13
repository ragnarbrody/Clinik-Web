<?php
include('./protect.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
</head>
<body style="display: flex;     flex-direction: column;">
    Seja bem-vindo(a) ao Clinik Flow <?php echo $_SESSION['nome'];?>

    <img src="./Imagens/eae.jpg" alt="" style="width: 30%;">

    <p>
        <a href="./logout.php">Sair</a>
    </p>
</body>
</html>