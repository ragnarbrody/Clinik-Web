<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/cadastrar_paciente.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <title>Cadastro de Usuário</title>
</head>
<body>
    <div class="addUser">
        <h2>Cadastro de Paciente</h2>
        <form action="processar_cadastroPac.php" method="POST" class="form_addUser">
            <div class="conteudoForm">
                <div class="conjInput">
                    <label for="nome">Nome completo:</label>
                    <input type="text" id="nome" name="nome" required><br>
                    <label for="CPF">CPF:</label>
                    <input type="number" id="CPF" name="CPF" required><br>
                </div>  
                <div class="conjInput">          
                    <label for="RG">RG:</label>
                    <input type="text" id="RG" name="RG"><br>
                    <label for="RNE">RNE:</label>
                    <input type="text" id="RNE" name="RNE"><br>
                </div>
                <div class="conjInput">          
                    <label for="nome_pai">Nome do Pai:</label>
                    <input type="text" id="nome_pai" name="nome_pai"><br>
                    <label for="nome_mae">Nome da Mãe:</label>
                    <input type="text" id="nome_mae" name="nome_mae" required><br>
                </div>
                <div class="conjInput">
                    <label for="estado_civil">Estado Civil:</label>
                    <select name="estado_civil" id="estado_civil" required>
                        <option value="casado">Casado</option>
                        <option value="solteiro">Solteiro</option>
                        <option value="separado">Separado</option>
                        <option value="divorciado">Divorciado</option>
                        <option value="viuvo">Viúvo</option>
                    </select>
                    <label for="sexo">Sexo:</label>
                    <select name="sexo" id="sexo" required>
                        <option value="masculino">Masculino</option>
                        <option value="feminino">Feminino</option>
                    </select>
                </div>
                <div class="conjInput">
                    <label for="etnia">Etnia:</label><br>
                    <select name="etnia" id="etnia" required>
                        <option value="branco">Branco</option>
                        <option value="preto">Preto</option>
                        <option value="pardo">Pardo</option>
                        <option value="amarelo">Amarelo</option>
                        <option value="indigena">Indígena</option>
                    </select><br>
                    <label for="nacionalidade">Nacionalidade:</label><br>
                    <input type="text" id="nacionalidade" name="nacionalidade" required><br>
                </div>
                <div class="conjInput">
                    <label for="data_nascimento">Data de nascimento:</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" required><br>
                    <label for="responsavel">Responsável Legal:</label>
                    <input type="text" id="responsavel" name="responsavel" required><br>
                </div>
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <label for="telefone">Telefone:</label>
                    <input type="tel" id="telefone" name="telefone" required><br>
                    <label for="nome_emergencia">Nome contato de emergência:</label>
                    <input type="text" id="nome_emergencia" name="nome_emergencia"><br>
                </div>
                <div class="conjInput">
                    <label for="telefone_emergencia">Telefone de Emergência:</label>
                    <input type="tel" id="telefone_emergencia" name="telefone_emergencia"><br>
                    <label for="parentesco_emergencia">Parentesco do contato de emergencia:</label>
                    <input type="text" id="parentesco_emergencia" name="parentesco_emergencia"><br>
                </div>
                <div class="conjInput">
                    <label for="CEP">CEP:</label>
                    <input type="number" id="CEP" name="CEP" required><br>
                    <label for="endereco_rua">Endereço:</label>
                    <input type="text" id="endereco_rua" name="endereco_rua" required><br>
                </div>
                <div class="conjInput">
                    <label for="endereco_numero">Número:</label>
                    <input type="number" id="endereco_numero" name="endereco_numero" required><br>
                    <label for="complemento">Complemento:</label>
                    <input type="text" id="complemento" name="complemento"><br>
                </div>
                <div class="conjInput">
                    <label for="carteirinha">Carteira de Saúde:</label>
                    <input type="number" id="carteirinha" name="carteirinha" required><br>
                </div>
            </div>
            <div class="enviarPac">  
                <input type="submit" value="Cadastrar">
            </div>
        </form>
    </div>
</body>
</html>
