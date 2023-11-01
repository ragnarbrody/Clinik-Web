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
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" required><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br>
                </div>  
                <div class="conjInput">          
                    <label for="nacionalidade">Nacionalidade:</label>
                    <input type="text" id="nacionalidade" name="nacionalidade" required><br>
                    <label for="setor">Setor:</label>
                    <input type="text" id="setor" name="setor" required><br>
                </div>
                <div class="conjInput">   
                    <label for="cargo">Cargo:</label> 
                    <select name="cargo" id="cargo" required>
                        <option value="ADM">ADM</option>
                        <option value="RECEPCIONISTA">Recepcionista</option>
                        <option value="ESPECIALISTA">Especialista</option>
                        <option value="CHEFE_DPTO">Chefe de setor</option>
                    </select><br>
                    <label for="crm	">CRM ou NF:</label>
                    <input type="text" id="crm" name="crm"><br>
                </div>
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <label for="apelido">Nome de usuário:</label>
                    <input type="text" id="apelido" name="apelido" required><br>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required><br>
                </div>
                <div class="conjInput">
                    <label for="especialidade">Área de Atuação/Especialidade:</label>
                    <input type="text" id="especialidade" name="especialidade"><br>
                    <label for="cpf">CPF:</label>
                    <input type="number" id="cpf" name="cpf" required><br>
                </div>
                <div class="conjInput">
                    <label for="rg">RG:</label>
                    <input type="text" id="rg" name="rg"><br>
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" required><br>
                    <label for="telefone">Telefone:</label>
                    <input type="number" id="telefone" name="telefone" required><br>
                </div>
            </div>
            <div class="enviarUser">  
                    <input type="submit" value="Cadastrar">
            </div>
        </form>
    </div>
</body>
</html>
