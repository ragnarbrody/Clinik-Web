<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/modal.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <title>Cadastro de Paciente</title>
</head>
<body>
    <div class="addUser">
        <h2>Cadastro de Paciente</h2>
        <form action="processar_cadastroPac.php" method="POST" class="form_addUser">
            <div class="conteudoForm">
                <div class="conjInput">
                    <label class="label" for="nome">Nome completo:</label>
                    <input class="input" type="text" id="nome" name="nome" required><br>
                    <label class="label" for="CPF">CPF:</label>
                    <input class="input" type="number" id="CPF" name="CPF"><br>
                </div>  
                <div class="conjInput">          
                    <label class="label" for="RG">RG:</label>
                    <input class="input"type="text" id="RG" name="RG"><br>
                    <label class="label" for="RNE">RNE:</label>
                    <input class="input" type="text" id="RNE" name="RNE">
                </div>
            </div>
            <div class="conteudoForm">
                <div class="conjInput">          
                    <label class="label" for="nome_pai">Nome do Pai:</label><br>
                    <input class="input" type="text" id="nome_pai" name="nome_pai"><br>
                    <label class="label" for="nome_mae">Nome da Mãe:</label><br>
                    <input class="input" type="text" id="nome_mae" name="nome_mae" required><br>
                </div>
                <div class="conjInput">
                    <label class="label" for="estado_civil">Estado Civil:</label><br>
                    <select class="input" name="estado_civil" id="estado_civil" required>
                        <option value="casado">Casado</option>
                        <option value="solteiro">Solteiro</option>
                        <option value="separado">Separado</option>
                        <option value="divorciado">Divorciado</option>
                        <option value="viuvo">Viúvo</option>
                    </select><br>
                    <label class="label" for="sexo">Sexo:</label><br>
                    <select class="input" name="sexo" id="sexo" required>
                        <option value="masculino">Masculino</option>
                        <option value="feminino">Feminino</option>
                    </select><br>
                </div>
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <label class="label" for="etnia">Etnia:</label><br>
                    <select class="input" name="etnia" id="etnia" required>
                        <option value="branco">Branco</option>
                        <option value="preto">Preto</option>
                        <option value="pardo">Pardo</option>
                        <option value="amarelo">Amarelo</option>
                        <option value="indigena">Indígena</option>
                    </select><br>
                    <label class="label" for="nacionalidade">Nacionalidade:</label><br>
                    <input class="input" type="text" id="nacionalidade" name="nacionalidade" required><br>
                </div>
                <div class="conjInput">
                    <label class="label" for="data_nascimento">Data de nascimento:</label><br>
                    <input class="input" type="date" id="data_nascimento" name="data_nascimento" required><br>
                    <label class="label" for="responsavel">Responsável Legal:</label><br>
                    <input class="input" type="text" id="responsavel" name="responsavel" required><br>
                </div>
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <label class="label" class="label"for="telefone">Telefone:</label><br>
                    <input class="input" type="tel" id="telefone" name="telefone" required><br>
                    <label class="label" for="nome_emergencia">Nome contato de emergência:</label><br>
                    <input class="input" type="text" id="nome_emergencia" name="nome_emergencia"><br>
                </div>
                <div class="conjInput">
                    <label class="label" for="telefone_emergencia">Telefone de Emergência:</label><br>
                    <input class="input" type="tel" id="telefone_emergencia" name="telefone_emergencia"><br>
                    <label class="label" for="parentesco_emergencia">Parentesco do contato de emergencia:</label><br>
                    <input class="input" type="text" id="parentesco_emergencia" name="parentesco_emergencia"><br>
                </div>
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <label class="label" for="CEP">CEP:</label><br>
                    <input class="input" type="number" id="CEP" name="CEP" required><br>
                    <label class="label" for="endereco_rua">Endereço:</label><br>
                    <input class="input" type="text" id="endereco_rua" name="endereco_rua" required><br>
                </div>
                <div class="conjInput">
                    <label class="label" for="endereco_numero">Número:</label><br>
                    <input class="input" type="number" id="endereco_numero" name="endereco_numero" required><br>
                    <label class="label" for="complemento">Complemento:</label><br>
                    <input class="input" type="text" id="complemento" name="complemento"><br>
                    <label class="label" for="carteirinha">Carteira de Saúde:</label><br>
                    <input class="input" type="number" id="carteirinha" name="carteirinha" required><br>
                </div>
            </div>
            <div class="enviarPac">  
                <input type="submit" value="Cadastrar">
            </div>
        </form>
    </div>
</body>
</html>
