<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/cadastrar_servico.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <title>Cadastro de Serviço</title>
</head>
<body>
    <div class="addUser">
        <h2>Cadastro de Serviço</h2>
        <form action="processar_cadastroServ.php" method="POST" class="form_addUser">
            <div class="conteudoForm">
                <div class="conjInput">
                    <label for="Servico">Servico:</label>
                    <input type="text" id="Servico" name="Servico" required><br>
                    <label for="Valor">Valor:</label>
                    <input type="number" id="Valor" name="Valor" step="any" required><br>
                </div>  
                <div class="conjInput">          
                    <label for="Descricao">Descrição:</label>
                    <textarea name="Descricao" id="Descricao" cols="30" rows="10"></textarea><br>
                    <label for="Especialidade">Especialidade:</label>
                    <input type="text" id="Especialidade" name="Especialidade"><br>
                </div>
                <div class="conjInput">          
                    <label for="Situacao">Situação:</label>
                    <select name="Situacao" id="Situacao">
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                    <label for="Duracao_Estimada">Duração Estimada:</label>
                    <input type="time" id="Duracao_Estimada" name="Duracao_Estimada"><br>
                </div>
            </div>
            <div class="enviarServ">  
                <input type="submit" value="Cadastrar">
            </div>
        </form>
    </div>
</body>
</html>
