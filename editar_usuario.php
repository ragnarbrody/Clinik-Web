<?php
include('./conexao.php');
include('./protect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar a atualização do usuário aqui
    // Recuperar dados do formulário e atualizar no banco de dados
    $id = $_POST['id'];
    $novoNome = $_POST['novoNome'];
    $novoCargo = $_POST['novoCargo'];
    $novoNick = $_POST['novoNick'];
    $novoEmail = $_POST['novoEmail'];
    $novoTel = $_POST['novoTel'];
    $novoCrm = $_POST['novoCrm'];
    $novoEspecialidade = $_POST['novoEspecialidade'];
    // ... Outros campos e lógica de atualização
    // Atualizar o nome e o cargo do usuário no banco de dados
    $sql = "UPDATE usuarios SET nome = '$novoNome', cargo = '$novoCargo', nickname = '$novoNick', email = '$novoEmail', telefone = '$novoTel', crm = '$novoCrm', especialidade = '$novoEspecialidade' WHERE id = $id";

    if ($mysqli->query($sql)) {
        echo '<script>
            alert("Nome e cargo do usuário atualizados com sucesso!");
            window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
        </script>'; 
    } else {
        echo "Erro ao atualizar o nome e o cargo do usuário: " . $mysqli->error;
    }
}

// Recuperar o ID do usuário da consulta GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar o usuário com base no ID para obter seus dados atuais
    $sql = "SELECT * FROM usuarios WHERE id = $id";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Usuário não encontrado.";
        exit;
    }
} else {
    // ID do usuário não fornecido, redirecionar ou mostrar uma mensagem de erro
    echo "ID do usuário não especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/editar_usuario.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <title>Editar Usuário</title>
</head>
<body>
    <div class="editUser">
        <h2>Editar Usuário</h2>
        <form action="editar_usuario.php" method="POST" class="form_editUser">
            <div class="conteudoForm">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="conjInput">
                    <label for="novoNome">Nome:</label>              
                    <input type="text" id="novoNome" name="novoNome" value="<?php echo $row['nome']; ?>"><br>
                    <label for="novoCargo">Cargo:</label>
                    <input type="text" id="novoCargo" name="novoCargo" value="<?php echo $row['cargo']; ?>"><br>
                </div>             
                <div class="conjInput">
                    <label for="novoNick">Nickname:</label>
                    <input type="text" id="novoNick" name="novoNick" value="<?php echo $row['nickname']; ?>"><br>
                    <label for="novoEmail">Email:</label>
                    <input type="text" id="novoEmail" name="novoEmail" value="<?php echo $row['email']; ?>"><br>
                </div>
                <div class="conjInput">
                    <label for="novoTel">Telefone:</label>
                    <input type="number" id="novoTel" name="novoTel" value="<?php echo $row['telefone']; ?>"><br>
                    <label for="novoCrm">CRM:</label>
                    <input type="text" id="novoCrm" name="novoCrm" value="<?php echo $row['crm']; ?>"><br>
                </div>   
                <div class="conjInput">
                    <label for="novoEspecialidade">Especialidade:</label>
                    <input type="text" id="novoEspecialidade" name="novoEspecialidade" value="<?php echo $row['especialidade']; ?>"><br>
                </div>                           
            </div>                     
            <div class="enviarUser">
                <input type="submit" value="Salvar">
            </div>          
        </form>
    </div>   
</body>
</html>
