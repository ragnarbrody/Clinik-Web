<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/cadastrar_usuario.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <title>Cadastro de Usuário</title>
</head>
<body>
    <div class="addUser">
        <h2>Cadastro de Usuário</h2>
        <form action="processar_cadastroUser.php" method="POST" class="form_addUser">
            <div class="conteudoForm">
                <div class="conjInput">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required><br>
                    <label for="cargo">Cargo:</label>
                    <input type="text" id="cargo" name="cargo" required><br>
                </div>  
                <div class="conjInput">          
                    <label for="novoNick">Nickname:</label>
                    <input type="text" id="nick" name="nick" required><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br>
                </div>
                <div class="conjInput">          
                    <label for="telefone">Telefone:</label>
                    <input type="number" id="telefone" name="telefone" required><br>
                    <label for="crm">CRM:</label>
                    <input type="text" id="crm" name="crm"><br>
                </div>
                <div class="conjInput">
                    <label for="especialidade">Especialidade:</label>
                    <input type="text" id="especialidade" name="especialidade"><br>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required><br>
                </div>
            </div>
            <div class="enviarUser">  
                    <input type="submit" value="Cadastrar">
            </div>
        </form>
    </div>
</body>
</html>
