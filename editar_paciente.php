<?php
include('./conexao.php');
include('./protect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar dados do formulário e atualizar no banco de dados
    $id = $_POST['id'];
    $novoNome = $_POST['novoNome'];
    $novoCPF = $_POST['novoCPF'];
    $novaRG = $_POST['novaRG'];
    $novoRNE = $_POST['novoRNE'];
    $novoNome_pai = $_POST['novoNome_pai'];
    $novoNome_mae = $_POST['novoNome_mae'];
    $novoEstado_civil = $_POST['novoEstado_civil'];
    $novoSexo = $_POST['novoSexo'];
    $novoEtnia = $_POST['novoEtnia'];
    $novaNacionalidade = $_POST['novaNacionalidade'];
    $novaData_nascimento = $_POST['novaData_nascimento'];
    $novoResponsavel = $_POST['novoResponsavel'];
    $novoTelefone = $_POST['novoTelefone'];
    $novoNome_emergencia = $_POST['novoNome_emergencia'];
    $novoTelefone_emergencia = $_POST['novoTelefone_emergencia'];
    $novoParentesco_emergencia = $_POST['novoParentesco_emergencia'];
    $novoCEP = $_POST['novoCEP'];
    $novoEndereco_rua = $_POST['novoEndereco_rua'];
    $novoEndereco_numero = $_POST['novoEndereco_numero'];
    $novoComplemento = $_POST['novoComplemento'];
    $novoCarteirinha = $_POST['novoCarteirinha'];
    // Atualizar os dados do paciente no banco de dados
    $sql = "UPDATE paciente SET nome_completo = '$novoNome', CPF = '$novoCPF', RG = '$novaRG', nome_pai = '$novoNome_pai', nome_mae = '$novoNome_mae', RNE = '$novoRNE', estado_civil = '$novoEstado_civil', sexo = '$novoSexo', etnia = '$novoEtnia', nacionalidade = '$novaNacionalidade', data_nascimento = '$novaData_nascimento', responsavel_legal = '$novoResponsavel', telefone = '$novoTelefone', nome_emergencia = '$novoNome_emergencia', telefone_emergencia = '$novoTelefone_emergencia', parentesco_emergencia = '$novoParentesco_emergencia', CEP = '$novoCEP', endereco_rua = '$novoEndereco_rua', endereco_numero = '$novoEndereco_numero', complemento = '$novoComplemento', numero_carteirinha = '$novoCarteirinha' WHERE ID = $id";

    if ($mysqli->query($sql)) {
        echo '<script>
            alert("Dados do paciente atualizados com sucesso!");
            window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
        </script>'; 
    } else {
        echo "Erro ao atualizar os dados do paciente: " . $mysqli->error;
    }
}

// Recuperar o ID do usuário da consulta GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar o usuário com base no ID para obter seus dados atuais
    $sql = "SELECT * FROM paciente WHERE ID = $id";
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
    <title>Editar Paciente</title>
</head>
<body>
    <div class="addUser">
        <h2>Editar Paciente</h2>
        <form action="editar_paciente.php" method="POST" class="form_addUser">
            <div class="conteudoForm">
                <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                <div class="conjInput">
                    <label class="label" for="novoNome">Nome Completo:</label>              
                    <input class="input" type="text" id="novoNome" name="novoNome" value="<?php echo $row['nome_completo']; ?>"><br>
                    <label class="label" for="novoCPF">CPF:</label>
                    <input class="input" type="number" id="novoCPF" name="novoCPF" value="<?php echo $row['CPF']; ?>"><br>
                </div>             
                <div class="conjInput">
                    <label class="label" for="novaRG">RG:</label>
                    <input class="input" type="text" id="novaRG" name="novaRG" value="<?php echo $row['RG']; ?>"><br>
                    <label class="label" for="novoRNE">RNE:</label>
                    <input class="input" type="text" id="novoRNE" name="novoRNE" value="<?php echo $row['RNE']; ?>"><br>
                </div>
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <label class="label" for="novoNome_pai">Nome do Pai:</label>
                    <input class="input" type="text" id="novoNome_pai" name="novoNome_pai" value="<?php echo $row['nome_pai']; ?>"><br>
                    <label class="label" for="novoNome_mae">Nome da Mãe:</label>
                    <input class="input" type="text" id="novoNome_mae" name="novoNome_mae" value="<?php echo $row['nome_mae']; ?>"><br>
                </div>
                <div class="conjInput">
                    <label class="label" for="novoEstado_civil">Estado Civil:</label> 
                    <select class="input" name="novoEstado_civil" id="novoEstado_civil">
                        <option value="casado" <?php if ($row['estado_civil'] == 'Casado') echo 'selected'; ?>>Casado</option>
                        <option value="solteiro" <?php if ($row['estado_civil'] == 'Solteiro') echo 'selected'; ?>>Solteiro</option>
                        <option value="separado" <?php if ($row['estado_civil'] == 'Separado') echo 'selected'; ?>>Separado</option>
                        <option value="divorciado" <?php if ($row['estado_civil'] == 'Divorciado') echo 'selected'; ?>>Divorciado</option>
                        <option value="viuvo" <?php if ($row['estado_civil'] == 'Viúvo') echo 'selected'; ?>>Viúvo</option>
                    </select>
                    <label class="label" for="novoSexo">Sexo:</label>
                    <select class="input" name="novoSexo" id="novoSexo">
                        <option value="masculino" <?php if ($row['sexo'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
                        <option value="feminino" <?php if ($row['sexo'] == 'Feminino') echo 'selected'; ?>>Feminino</option>
                    </select> 
                </div>
            </div>    
            <div class="conteudoForm"> 
                <div class="conjInput">
                    <label class="label" for="novoEtnia">Etnia:</label><br>
                    <select class="input" name="novoEtnia" id="novoEtnia">
                        <option value="branco" <?php if ($row['etnia'] == 'Branco') echo 'selected'; ?>>Branco</option>
                        <option value="preto" <?php if ($row['etnia'] == 'Preto') echo 'selected'; ?>>Preto</option>
                        <option value="pardo" <?php if ($row['etnia'] == 'Pardo') echo 'selected'; ?>>Pardo</option>
                        <option value="amarelo" <?php if ($row['etnia'] == 'Amarelo') echo 'selected'; ?>>Amarelo</option>
                        <option value="indigena" <?php if ($row['etnia'] == 'Indígena') echo 'selected'; ?>>Indígena</option>
                    </select><br>
                    <label class="label" for="novaNacionalidade">Nacionalidade:</label><br>
                    <input class="input" type="text" id="novaNacionalidade" name="novaNacionalidade" value="<?php echo $row['nacionalidade']; ?>"><br> 
                </div>
                <div class="conjInput">
                    <label class="label" for="novaData_nascimento">Data de nascimento:</label>
                    <input class="input" type="date" id="novaData_nascimento" name="novaData_nascimento" value="<?php echo $row['data_nascimento']; ?>"><br>
                    <label class="label" for="novoResponsavel">Responsável Legal:</label>
                    <input class="input" type="text" id="novoResponsavel" name="novoResponsavel" value="<?php echo $row['responsavel_legal']; ?>"><br>
                </div>                                    
            </div>   
            <div class="conteudoForm">
                <div class="conjInput">
                    <label class="label" for="novoTelefone">Telefone:</label>
                    <input class="input" type="tel" id="novoTelefone" name="novoTelefone" value="<?php echo $row['telefone']; ?>"><br>
                    <label class="label" for="novoNome_emergencia">Nome contato de emergência:</label>
                    <input class="input" type="text" id="novoNome_emergencia" name="novoNome_emergencia" value="<?php echo $row['nome_emergencia']; ?>"><br>
                </div>
                <div class="conjInput">
                    <label class="label" for="novoTelefone_emergencia">Telefone de Emergência:</label>
                    <input class="input" type="tel" id="novoTelefone_emergencia" name="novoTelefone_emergencia" value="<?php echo $row['telefone_emergencia']; ?>"><br>
                    <label class="label" for="novoParentesco_emergencia">Parentesco do contato de emergencia:</label>
                    <input class="input" type="text" id="novoParentesco_emergencia" name="novoParentesco_emergencia" value="<?php echo $row['parentesco_emergencia']; ?>"><br>
                </div>
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <label class="label" for="novoCEP">CEP:</label>
                    <input class="input" type="number" id="novoCEP" name="novoCEP" value="<?php echo $row['CEP']; ?>"><br>
                    <label class="label" for="novoEndereco_rua">Endereço:</label>
                    <input class="input" type="text" id="novoEndereco_rua" name="novoEndereco_rua" value="<?php echo $row['endereco_rua']; ?>"><br>
                </div>
                <div class="conjInput">
                    <label class="label" for="novoEndereco_numero">Número:</label>
                    <input class="input" type="number" id="novoEndereco_numero" name="novoEndereco_numero" value="<?php echo $row['endereco_numero']; ?>"><br>
                    <label class="label" for="novoComplemento">Complemento:</label>
                    <input class="input" type="text" id="novoComplemento" name="novoComplemento" value="<?php echo $row['complemento']; ?>"><br>
                    <label class="label" for="novoCarteirinha">Carteira de Saúde:</label>
                    <input class="input" type="number" id="novoCarteirinha" name="novoCarteirinha" value="<?php echo $row['numero_carteirinha']; ?>"><br>
                </div>
            </div>                  
            <div class="enviarUser">
                <input type="submit" value="Salvar">
            </div>          
        </form>
    </div>   
</body>
</html>
