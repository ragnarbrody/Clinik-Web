<?php
include('./conexao.php');
include('./protect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar dados do formulário e atualizar no banco de dados
    $id = $_POST['id'];
    $novoServico = $_POST['novoServico'];
    $novoValor = $_POST['novoValor'];
    $novoDescricao = $_POST['novoDescricao'];
    $novoEspecialidade = $_POST['novoEspecialidade'];
    $novoSituacao = $_POST['novoSituacao'];
    $novoDuracao_Estimada = $_POST['novoDuracao_Estimada'];
    // Atualizar os dados do usuário no banco de dados
    $sql = "UPDATE servicos SET Servico = '$novoServico', Valor = '$novoValor', Descricao = '$novoDescricao', Especialidade = '$novoEspecialidade', Situacao = '$novoSituacao', Duracao_Estimada = '$novoDuracao_Estimada' WHERE ID = $id";

    if ($mysqli->query($sql)) {
        echo '<script>
            alert("Dados do serviço atualizados com sucesso!");
            window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
        </script>'; 
    } else {
        echo "Erro ao atualizar os dados do serviço: " . $mysqli->error;
    }
}

// Recuperar o ID do usuário da consulta GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar o usuário com base no ID para obter seus dados atuais
    $sql = "SELECT * FROM servicos WHERE ID = $id";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Serviço não encontrado.";
        exit;
    }
} else {
    // ID do usuário não fornecido, redirecionar ou mostrar uma mensagem de erro
    echo "ID do serviço não especificado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/editar_servico.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <title>Editar Serviço</title>
</head>
<body>
    <div class="editUser">
        <h2>Editar Serviço</h2>
        <form action="editar_servico.php" method="POST" class="form_editUser">
            <div class="conteudoForm">
                <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                <div class="conjInput">
                    <label for="novoServico">Servico:</label>              
                    <input type="text" id="novoServico" name="novoServico" value="<?php echo $row['Servico']; ?>"><br>
                    <label for="novoValor">Valor:</label>
                    <input type="number" id="novoValor" name="novoValor" value="<?php echo $row['Valor']; ?>"><br>
                </div>    
                <div class="conjInput">          
                    <label for="novoDescricao">Descrição:</label>
                    <textarea name="novoDescricao" id="novoDescricao" cols="30" rows="10"><?php echo $row['Descricao']; ?></textarea><br>
                    <label for="novoEspecialidade">Especialidade:</label>
                    <input type="text" id="novoEspecialidade" name="novoEspecialidade" value="<?php echo $row['Especialidade']; ?>"><br>
                </div>
                <div class="conjInput">          
                    <label for="novoSituacao">Situação:</label>
                    <select name="novoSituacao" id="novoSituacao">
                        <option value="Ativo" <?php if ($row['Situacao'] == 'Ativo') echo 'selected'; ?>>Ativo</option>
                        <option value="Inativo" <?php if ($row['Situacao'] == 'Inativo') echo 'selected'; ?>>Inativo</option>
                    </select>
                    <label for="novoDuracao_Estimada">Duração Estimada:</label>
                    <input type="time" id="novoDuracao_Estimada" name="novoDuracao_Estimada" value="<?php echo $row['Duracao_Estimada']; ?>"><br>
                </div>         
            </div>                                               
            <div class="enviarServ">
                <input type="submit" value="Salvar">
            </div>          
        </form>
    </div>   
</body>
</html>
