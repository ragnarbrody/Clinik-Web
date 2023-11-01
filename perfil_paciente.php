<?php
include('./conexao.php');
include('./protect.php');

// Verifica se o parâmetro ID foi passado na URL
if (isset($_GET['id'])) {
    $pacienteId = $_GET['id'];

    // Consulta SQL para obter os detalhes do paciente com base no ID fornecido
    $sql_code = "SELECT * FROM paciente WHERE ID = $pacienteId";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    // Verificar se o paciente foi encontrado
    if ($sql_query->num_rows > 0) {
        $paciente = $sql_query->fetch_assoc();
    } else {
        echo 'Paciente não encontrado.';
    }
} else {
    echo 'ID do paciente não fornecido.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/menu.css">
        <link rel="stylesheet" href="./styles/perfil_paciente.css">
        <link rel="stylesheet" href="./styles/footer.css">
        <link rel="icon" href="./Imagens/IconeLogo.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <div class="conteudoPerfil">
                <div class="containerConteudo">
                    <h2>Bem Vindo(a)!</h2>
                    <h3>Nesta página você encontra os dados do paciente:</h3>
                    <div class="dados">
                        <div class="divSeparador">
                            <p>ID do paciente é: <?php echo $paciente['ID'];?></p>
                            <p>Nome do paciente é: <?php echo $paciente['nome_completo'];?></p>
                            <p>CPF do paciente é: <?php echo $paciente['CPF'];?></p>
                            <p>RG do paciente é: <?php echo $paciente['RG'];?></p>
                            <p>RNE do paciente é: <?php echo $paciente['RNE'];?></p>
                            <p>Nome do pai do paciente é: <?php echo $paciente['nome_pai'];?></p>
                            <p>Nome da mãe do paciente é: <?php echo $paciente['nome_mae'];?></p>                        
                        </div>                    
                        <div class="divSeparador">
                            <p>Estado civil do paciente é: <?php echo $paciente['estado_civil'];?></p>
                            <p>Sexo do paciente é: <?php echo $paciente['sexo'];?></p>
                            <p>Etnia do paciente é: <?php echo $paciente['etnia'];?></p>
                            <p>Nacionalidade do paciente é: <?php echo $paciente['nacionalidade'];?></p>
                            <p>Data de nascimento do paciente é: <?php echo $paciente['data_nascimento'];?></p>
                            <p>Responsavel legal do paciente é: <?php echo $paciente['responsavel_legal'];?></p>
                            <p>Telefone do paciente é: <?php echo $paciente['telefone'];?></p>
                        </div>
                        <div class="divSeparador">
                            <p>Contato de emergencia do paciente é: <?php echo $paciente['nome_emergencia'];?></p>
                            <p>Telefone do contato de emergencia é: <?php echo $paciente['telefone_emergencia'];?></p>
                            <p>Parentesco do contato de emergencia é: <?php echo $paciente['parentesco_emergencia'];?></p>
                            <p>CEP do paciente é: <?php echo $paciente['CEP'];?></p>
                            <p>Endereço do paciente é: <?php echo $paciente['endereco_rua'];?></p>
                        </div>
                        <div class="divSeparador">
                            <p>Número da residência é: <?php echo $paciente['endereco_numero'];?></p>
                            <p>complemento da residência é: <?php echo $paciente['complemento'];?></p>
                            <p>Carteirinha do paciente é: <?php echo $paciente['numero_carteirinha'];?></p> 
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