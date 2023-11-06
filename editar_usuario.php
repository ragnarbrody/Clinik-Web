<?php
include('./conexao.php');
include('./protect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar dados do formulário e atualizar no banco de dados
    $id = $_POST['id'];
    $novoNome = $_POST['novoNome'];
    $novoEmail = $_POST['novoEmail'];
    $novaNacionalidade = $_POST['novaNacionalidade'];
    $novoSetor = $_POST['novoSetor'];
    $novoCargo = $_POST['novoCargo'];
    $novoCrm = $_POST['novoCrm'];
    $novoApelido = $_POST['novoApelido'];
    $novaSenha = $_POST['novaSenha'];
    $novaEspecialidade = $_POST['novaEspecialidade'];
    $novoCpf = $_POST['novoCpf'];
    $novoRg = $_POST['novoRg'];
    $novaData_nascimento = $_POST['novaData_nascimento'];
    $novoTelefone = $_POST['novoTelefone'];
    // Atualizar os dados do usuário no banco de dados
    $sql = "UPDATE usuarios SET Nome = '$novoNome', Email = '$novoEmail', Nacionalidade = '$novaNacionalidade', Setor = '$novoSetor', Cargo = '$novoCargo', Crm = '$novoCrm', Apelido = '$novoApelido', Senha = '$novaSenha', Especialidade = '$novaEspecialidade', CPF = '$novoCpf', RG = '$novoRg', Data_nascimento = '$novaData_nascimento', Telefone = '$novoTelefone' WHERE ID = $id";

    if ($mysqli->query($sql)) {
        echo '<script>
            alert("Dados do usuário atualizados com sucesso!");
            window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
        </script>'; 
    } else {
        echo "Erro ao atualizar os dados do usuário: " . $mysqli->error;
    }
}

// Recuperar o ID do usuário da consulta GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar o usuário com base no ID para obter seus dados atuais
    $sql = "SELECT * FROM usuarios WHERE ID = $id";
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
<html lang="pt-br">
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
                <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                <div class="conjInput">
                    <label for="novoNome">Nome Completo:</label>              
                    <input type="text" id="novoNome" name="novoNome" value="<?php echo $row['Nome']; ?>"><br>
                    <label for="novoEmail">Email:</label>
                    <input type="email" id="novoEmail" name="novoEmail" value="<?php echo $row['Email']; ?>"><br>
                </div>             
                <div class="conjInput">
                    <label for="novaNacionalidade">Nacionalidade:</label>
                    <input type="text" id="novaNacionalidade" name="novaNacionalidade" value="<?php echo $row['Nacionalidade']; ?>"><br>
                    <label for="novoSetor">Setor:</label>
                    <input type="text" id="novoSetor" name="novoSetor" value="<?php echo $row['Setor']; ?>"><br>
                </div>
                <div class="conjInput">
                    <label for="novoCargo">Cargo:</label> 
                    <select name="novoCargo" id="novoCargo">
                        <?php if ($row['Cargo'] == 'ADM'): ?>
                            <option value="ADM" selected>ADM</option>
                        <?php endif; ?>
                        <option value="RECEPCIONISTA" <?php if ($row['Cargo'] == 'RECEPCIONISTA') echo 'selected'; ?>>Recepcionista</option>
                        <option value="ESPECIALISTA" <?php if ($row['Cargo'] == 'ESPECIALISTA') echo 'selected'; ?>>Especialista</option>
                        <option value="CHEFE_DPTO" <?php if ($row['Cargo'] == 'CHEFE_DPTO') echo 'selected'; ?>>Chefe de setor</option>
                    </select><br>
                    <label for="novoCrm	">CRM ou NF:</label>
                    <input type="text" id="novoCrm" name="novoCrm" value="<?php echo $row['CRM']; ?>"><br>
                </div> 
            </div>
            <div class="conteudoForm">  
                <div class="conjInput">
                    <label for="novoApelido">Nome de usuário:</label>
                    <input type="text" id="novoApelido" name="novoApelido" value="<?php echo $row['Apelido']; ?>"><br>
                    <label for="novaSenha">Senha:</label>
                    <input type="password" id="novaSenha" name="novaSenha" value="<?php echo $row['Senha']; ?>"><br>
                </div>
                <div class="conjInput">
                    <label for="novaEspecialidade">Área de Atuação/Especialidade:</label>
                    <input type="text" id="novaEspecialidade" name="novaEspecialidade" value="<?php echo $row['Especialidade']; ?>"><br>
                    <label for="novoCpf">CPF:</label>
                    <input type="number" id="novoCpf" name="novoCpf" value="<?php echo $row['CPF']; ?>"><br>
                </div> 
                <div class="conjInput">
                    <label for="novoRg">RG:</label>
                    <input type="text" id="novoRg" name="novoRg" value="<?php echo $row['RG']; ?>"><br>
                    <label for="novaData_nascimento">Data de Nascimento:</label>
                    <input type="date" id="novaData_nascimento" name="novaData_nascimento" value="<?php echo $row['Data_nascimento']; ?>"><br>
                    <label for="novoTelefone">Telefone:</label>
                    <input type="number" id="novoTelefone" name="novoTelefone" value="<?php echo $row['Telefone']; ?>"><br>
                </div> 
            </div>                                                
            <div class="enviarUser">
                <input type="submit" value="Salvar">
            </div>          
        </form>
    </div>   
</body>
</html>
