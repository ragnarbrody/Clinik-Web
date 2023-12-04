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

    // Upload da nova foto
    $fotoPath = '';

    if ($_FILES['foto']['error'] == 0) {
        $uploadDir = './Imagens/fotosPerfil/';
        $uploadFile = $uploadDir . basename($_FILES['foto']['name']);
        
        // Move o arquivo para o diretório de upload
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
            $fotoPath = $uploadFile;
        } else {
            echo "Erro no upload da foto.";
            exit;
        }
    }else {
        // Não houve upload de nova foto, manter o caminho existente
        $fotoPath = $_POST['fotoExistente'];
    }

    // Atualizar os dados do usuário no banco de dados, incluindo o caminho da foto
    $sql = "UPDATE usuarios SET Nome = '$novoNome', Email = '$novoEmail', Nacionalidade = '$novaNacionalidade', Setor = '$novoSetor', Cargo = '$novoCargo', Crm = '$novoCrm', Apelido = '$novoApelido', Senha = '$novaSenha', Especialidade = '$novaEspecialidade', CPF = '$novoCpf', RG = '$novoRg', Data_nascimento = '$novaData_nascimento', Telefone = '$novoTelefone', Foto = '$fotoPath' WHERE ID = $id";

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
    <link rel="stylesheet" href="./styles/modal.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <title>Editar Usuário</title>
</head>
<body>
    <div class="addUser">
        <h2>Editar Usuário</h2>
        <form action="editar_usuario.php" method="POST" class="form_addUser" enctype="multipart/form-data">
            <div class="conteudoForm">
                <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                <div class="conjInputFoto">
                    <?php
                        // Verifica se há uma foto existente
                        if (isset($row['Foto']) && !empty($row['Foto']) && file_exists($row['Foto'])) {
                            echo '<img id="thumbnail" src="' . $row['Foto'] . '" alt="Thumbnail da Foto"><br>';
                        }
                        else{
                            echo '<img id="thumbnail" src="#" alt="Thumbnail da Foto" style="display:none"><br>';
                        }
                    ?>
                    <input type="hidden" name="fotoExistente" value="<?php echo $row['Foto']; ?>">
                    <label class="label" for="foto" id="lblFoto">Clique para escolher uma foto</label><br>
                    <input class="input" type="file" id="foto" name="foto" accept="image/*" style="display:none" onchange="exibirThumbnail()"><br>
                    <script>
                        function exibirThumbnail() {
                            var inputFoto = document.getElementById('foto');
                            var thumbnail = document.getElementById('thumbnail');

                            if (inputFoto.files && inputFoto.files[0]) {
                                var reader = new FileReader();

                                reader.onload = function (e) {
                                    thumbnail.src = e.target.result;
                                    thumbnail.style.display = 'block';
                                };

                                reader.readAsDataURL(inputFoto.files[0]);
                            }
                        }
                    </script>
                </div>             
                <div class="conjInput">
                    <label class="label" for="novoNome">Nome Completo:</label><br>            
                    <input class="input" type="text" id="novoNome" name="novoNome" value="<?php echo $row['Nome']; ?>"><br>
                    <label class="label" for="novoEmail">Email:</label><br>
                    <input class="input" type="email" id="novoEmail" name="novoEmail" value="<?php echo $row['Email']; ?>"><br>
                    <label class="label" for="novaNacionalidade">Nacionalidade:</label><br>
                    <input class="input" type="text" id="novaNacionalidade" name="novaNacionalidade" value="<?php echo $row['Nacionalidade']; ?>"><br>
                </div>
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <label class="label" for="novoCargo">Cargo:</label><br>
                    <select class="input" name="novoCargo" id="novoCargo">
                        <?php if ($row['Cargo'] == 'ADM'): ?>
                            <option value="ADM" selected>ADM</option>
                        <?php endif; ?>
                        <?php if ($row['Cargo'] == 'CHEFE_DPTO') : ?>
                            <option value="CHEFE_DPTO" selected>Chefe de setor</option>
                        <?php endif; ?>
                        <?php if ($_SESSION['cargo'] == 'ADM') : ?>
                            <?php if ($row['Cargo'] != 'CHEFE_DPTO') : ?>
                                <option value="CHEFE_DPTO" <?php if ($row['Cargo'] == 'CHEFE_DPTO') echo 'selected'; ?>>Chefe de setor</option>
                            <?php endif; ?>           
                            <option value="RECEPCIONISTA" <?php if ($row['Cargo'] == 'RECEPCIONISTA') echo 'selected'; ?>>Recepcionista</option>
                        <?php endif; ?>
                        <option value="ESPECIALISTA" <?php if ($row['Cargo'] == 'ESPECIALISTA') echo 'selected'; ?>>Especialista</option>
                    </select><br>
                    <label class="label" for="novoCrm	">CRM ou NF:</label><br>
                    <input class="input" type="text" id="novoCrm" name="novoCrm" value="<?php echo $row['CRM']; ?>"><br>
                </div> 
                <div class="conjInput">
                    <label class="label" for="novoApelido">Nome de usuário:</label><br>
                    <input class="input" type="text" id="novoApelido" name="novoApelido" value="<?php echo $row['Apelido']; ?>"><br>
                    <label class="label" for="novaSenha">Senha:</label><br>
                    <input class="input" type="password" id="novaSenha" name="novaSenha" value="<?php echo $row['Senha']; ?>"><br>
                </div>
            </div>
            <div class="conteudoForm">  
                <div class="conjInput">
                    <label class="label" for="novaEspecialidade">Área de Atuação/Especialidade:</label><br>
                    <input class="input" type="text" id="novaEspecialidade" name="novaEspecialidade" value="<?php echo $row['Especialidade']; ?>"><br>
                    <label class="label" for="novoCpf">CPF:</label><br>
                    <input class="input" type="number" id="novoCpf" name="novoCpf" value="<?php echo $row['CPF']; ?>"><br>
                    <label class="label" for="novoSetor">Setor:</label><br>
                    <?php if ($_SESSION['cargo'] == 'ADM') : ?>
                        <input class="input" type="text" id="novoSetor" name="novoSetor" value="<?php echo $row['Setor']; ?>"><br>
                    <?php endif; ?>
                    <?php if ($_SESSION['cargo'] == 'CHEFE_DPTO') : ?>
                        <input class="input" type="text" id="novoSetor" name="novoSetor" value="<?php echo $row['Setor']; ?>" readonly><br>
                    <?php endif; ?>              
                </div> 
                <div class="conjInput">
                    <label class="label" for="novoRg">RG:</label><br>
                    <input class="input" type="text" id="novoRg" name="novoRg" value="<?php echo $row['RG']; ?>"><br>
                    <label class="label" for="novaData_nascimento">Data de Nascimento:</label><br>
                    <input class="input" type="date" id="novaData_nascimento" name="novaData_nascimento" value="<?php echo $row['Data_nascimento']; ?>"><br>
                    <label class="label" for="novoTelefone">Telefone:</label><br>
                    <input class="input"type="number" id="novoTelefone" name="novoTelefone" value="<?php echo $row['Telefone']; ?>"><br>
                </div> 
            </div>                                                
            <div class="enviarUser">
                <input type="submit" value="Salvar">
            </div>          
        </form>
    </div>   
</body>
</html>
