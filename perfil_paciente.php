<?php
include('./conexao.php');
include('./protect.php');

$pacienteId = '';

// Verifica se o parâmetro ID foi passado na URL
if (isset($_GET['id'])) {
    $pacienteId = $_GET['id'];

    // Consulta SQL para obter os detalhes do paciente com base no ID fornecido
    $sql_code = "SELECT * FROM paciente WHERE ID = $pacienteId";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    // Verificar se o paciente foi encontrado
    if ($sql_query->num_rows > 0) {
        $paciente = $sql_query->fetch_assoc();
    } else {
        echo 'Paciente não encontrado.';
    }
} else {
    echo 'ID do paciente não fornecido.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/menu.css">
        <link rel="stylesheet" href="./styles/perfil_paciente.css">
        <link rel="stylesheet" href="./styles/footer.css">
        <link rel="icon" href="./Imagens/IconeLogo.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="./scripts/menubarra.js"></script>
        <script>
            var pacienteId = <?php echo json_encode($pacienteId); ?>;
        </script>
        <title>Perfil</title>
    </head>
    <body>
        <!--////////--> 
        <?php include 'header.php'; ?>
        <!--////////--> 
        <main>
            <!-- classes para criação dos menus em desktop e mobile-->
            <?php include 'menu.php'; ?>
            <!--////////--> 
            <div class="conteudoPerfil">
                <div class="containerConteudo">
                    <div class="headerTab">
                        <div class="btnHeader">
                            <a onclick="openModalHistorico(<?php echo $pacienteId; ?>)">Histórico</a>
                        </div>
                        <div class="titHeader">
                            <h2>Dados do paciente:</h2>       
                        </div>
                    </div>
                    <div class="dados">
                        <div class="divSeparador">
                            <input type="hidden" value="<?php echo $paciente['ID'];?>">
                            <label class="titLabel" for="dado">Nome: </label><p class="dado"><?php echo $paciente['nome_completo'];?></p>
                            <label class="titLabel" for="dado">CPF: </label><p class="dado"><?php echo $paciente['CPF'];?></p>
                            <?php if (isset($paciente['RG']) && !empty($paciente['RG'])): ?>
                                <label class="titLabel" for="dado">RG: </label><p class="dado"><?php echo $paciente['RG'];?></p>
                            <?php else: ?>
                                <label class="titLabel" for="dado">RG: </label><p class="dado">"Sem informação"</p>
                            <?php endif; ?>
                            <?php if (isset($paciente['RNE']) && !empty($paciente['RNE'])): ?>
                                <label class="titLabel" for="dado">RNE: </label><p class="dado"><?php echo $paciente['RNE'];?></p>
                            <?php else: ?>
                                <label class="titLabel" for="dado">RNE: </label><p class="dado">"Sem informação"</p>
                            <?php endif; ?>       
                            <?php if (isset($paciente['nome_pai']) && !empty($paciente['nome_pai'])): ?>
                                <label class="titLabel" for="dado">Nome do pai: </label><p class="dado"><?php echo $paciente['nome_pai'];?></p>
                            <?php else: ?>
                                <label class="titLabel" for="dado">Nome do pai: </label><p class="dado">"Sem informação"</p>
                            <?php endif; ?>                   
                            <label class="titLabel" for="dado">Nome da mãe: </label><p class="dado"><?php echo $paciente['nome_mae'];?></p>                        
                        </div>                    
                        <div class="divSeparador">
                            <label class="titLabel" for="dado">Estado civil: </label><p class="dado"><?php echo $paciente['estado_civil'];?></p>
                            <label class="titLabel" for="dado">Sexo: </label><p class="dado"><?php echo $paciente['sexo'];?></p>
                            <label class="titLabel" for="dado">Etnia: </label><p class="dado"><?php echo $paciente['etnia'];?></p>
                            <label class="titLabel" for="dado">Nacionalidade: </label><p class="dado"><?php echo $paciente['nacionalidade'];?></p>
                            <label class="titLabel" for="dado">Data de nascimento: </label><p class="dado"><?php echo $paciente['data_nascimento'];?></p>
                            <label class="titLabel" for="dado">Responsavel legal: </label><p class="dado"><?php echo $paciente['responsavel_legal'];?></p>                       
                        </div>
                        <div class="divSeparador">
                            <label class="titLabel" for="dado">CEP: </label><p class="dado"><?php echo $paciente['CEP'];?></p>
                            <label class="titLabel" for="dado">Endereço: </label><p class="dado"><?php echo $paciente['endereco_rua'];?></p>
                            <?php if (isset($paciente['nome_emergencia']) && !empty($paciente['nome_emergencia'])): ?>
                                <label class="titLabel" for="dado">Contato de emergência: </label><p class="dado"><?php echo $paciente['nome_emergencia'];?></p>
                            <?php else: ?>
                                <label class="titLabel" for="dado">Contato de emergência: </label><p class="dado">"Sem informação"</p>
                            <?php endif; ?>
                            <?php if (isset($paciente['telefone_emergencia']) && !empty($paciente['telefone_emergencia'])): ?>
                                <label class="titLabel" for="dado">Telefone contato de emergencia: </label><p class="dado"><?php echo $paciente['telefone_emergencia'];?></p>
                            <?php else: ?>
                                <label class="titLabel" for="dado">Telefone contato de emergencia: </label><p class="dado">"Sem informação"</p>
                            <?php endif; ?>
                            <?php if (isset($paciente['parentesco_emergencia']) && !empty($paciente['parentesco_emergencia'])): ?>
                                <label class="titLabel" for="dado">Parentesco contato de emergencia: </label><p class="dado"><?php echo $paciente['parentesco_emergencia'];?></p>
                            <?php else: ?>
                                <label class="titLabel" for="dado">Parentesco contato de emergencia: </label><p class="dado">"Sem informação"</p>
                            <?php endif; ?>
                        </div>
                        <div class="divSeparador">
                            <label class="titLabel" for="dado">Número da residência: </label><p class="dado"><?php echo $paciente['endereco_numero'];?></p>
                            <?php if (isset($paciente['parentesco_emergencia']) && !empty($paciente['parentesco_emergencia'])): ?>
                                <label class="titLabel" for="dado">complemento: </label><p class="dado"><?php echo $paciente['complemento'];?></p>
                            <?php else: ?>
                                <label class="titLabel" for="dado">complemento </label><p class="dado">"Sem informação"</p>
                            <?php endif; ?>
                            <label class="titLabel" for="dado">Carteirinha: </label><p class="dado"><?php echo $paciente['numero_carteirinha'];?></p> 
                            <label class="titLabel" for="dado">Telefone: </label><p class="dado"><?php echo $paciente['telefone'];?></p>
                        </div>
                    </div>
                </div>
                <!--Os modais abaixo só aparecem quando chamados pelas respectivas funções-->
                <div class="modal">
                    <div class="modal-content" id="historicoAtd">
                        <span class="historico-btn" onclick="closeModal()">&times;</span>
                        <iframe src="historico_paciente.php" width="100%" height="400"></iframe>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="footerLogo">
                <img src="./Imagens/Logo.png" alt="Logo do aplicativo Clinik Flow" class="Clinik">
            </div>
        </footer>    
        <script src="./scripts/funcoesModal.js"></script>   
    </body>
</html>