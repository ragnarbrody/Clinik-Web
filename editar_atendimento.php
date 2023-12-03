<?php
session_start();
include('conexao.php');
include('protect.php');

// Chama a função para buscar dados com base no ID_clinica do usuário logado
$dadosClinica = buscarDadosClinica($_SESSION['ID_clinica']);

$atendimentoParaEditar = null;

if (isset($_GET['protocolo'])) {
    $protocolo = $_GET['protocolo'];

    // Consulta SQL para obter os dados do atendimento pelo ID
    $sqlEditarAtendimento = "SELECT * FROM atendimentos WHERE Protocolo = '$protocolo'";
    $resultEditarAtendimento = $mysqli->query($sqlEditarAtendimento);

    if ($resultEditarAtendimento->num_rows > 0) {
        $atendimentoParaEditar = $resultEditarAtendimento->fetch_assoc();

        // Converte a data do formato do banco de dados para o formato desejado
        $atendimentoParaEditar['Data_atendimento'] = date('Y-m-d', strtotime($atendimentoParaEditar['Data_atendimento']));
        
        // Pega a situação do atendimento
        $situacao = $atendimentoParaEditar['Situacao'];

        // Define o serviço selecionado
        $selectedServico = $atendimentoParaEditar['Servico'];

        // Consulta SQL para obter os dados do serviço pelo nome
        $sqlServico = "SELECT * FROM servicos WHERE Servico = '$selectedServico'";
        $resultServico = $mysqli->query($sqlServico);

        if ($resultServico->num_rows > 0) {
            $servico = $resultServico->fetch_assoc();
            $setorDoServico = $servico['Especialidade'];
        } else {
            // Trata erro, serviço não encontrado
            echo "Serviço não encontrado.";
            exit;
        }

        $setorDoAtendimento = $setorDoServico;

        // Consulta SQL para obter o email do paciente
        $sqlEmailPaciente = "SELECT email FROM paciente WHERE ID = '{$atendimentoParaEditar['ID_paciente']}'";
        $resultEmailPaciente = $mysqli->query($sqlEmailPaciente);

        if ($resultEmailPaciente->num_rows > 0) {
            $emailPaciente = $resultEmailPaciente->fetch_assoc()['email'];
        } else {
            // Trata erro, email do paciente não encontrado
            echo "Email do paciente não encontrado.";
            exit;
        }

        // Obtém o horário de início do atendimento
        $horarioInicio = date('H:i', strtotime($atendimentoParaEditar['Horario_inicio']));

    } else {
        // Trata erro, atendimento não encontrado
        echo "Atendimento não encontrado.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/modal.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <?php
        if ($situacao == 'Ativo') {
            echo "<title>Edição de Atendimento</title>";
        } else  if ($situacao == 'Atrasado') {
            echo "<title>Edição de Atendimento Atrasado</title>";
        }  
        else  if ($situacao == 'Agendado') {
            echo "<title>Edição de Agendamento</title>";
        } 
    ?>
</head>
<body>
    <div class="addUser">
        <?php
            if ($situacao == 'Ativo') {
                echo "<h2>Edição de Atendimento</h2>";
            } else  if ($situacao == 'Atrasado') {
                echo "<h2>Edição de Atendimento Atrasado</h2>";
            }  
            else  if ($situacao == 'Agendado') {
                echo "<h2>Edição de Agendamento</h2>";
            } 
        ?>
        <form action="processar_atualizacaoAtd.php" method="POST" class="form_addUser">
            <div class="conteudoForm">
                <div class="conjInput">
                    <label class="label" for="Servico">Servico:</label><br>
                    <input class="input" type="text" name="Servico" id="Servico" readonly value="<?php echo $atendimentoParaEditar['Servico']; ?>">
                    <label class="label" id="LabelProf_responsavel" for="Prof_responsavel">Profissional Responsável:</label><br>
                    <select class="input" name="Prof_responsavel" id="Prof_responsavel" required>
                        <option value=''></option>
                        <?php
                        foreach($dadosClinica['profissionais'] as $profissional) {
                            if ($profissional['Setor'] == $setorDoAtendimento) {
                                $selected = ($profissional['Nome'] == $atendimentoParaEditar['Prof_responsavel']) ? 'selected' : '';
                                echo "<option value='{$profissional['Nome']}' data-id='{$profissional['ID']}' $selected>{$profissional['Nome']}</option>";
                            }
                        }
                        ?>
                    </select><br>
                </div> 
                <div class="conjInput">
                    <label class="label" for="Paciente">Paciente:</label><br>
                    <input class="input" type="text" name="Paciente" id="Paciente" readonly value="<?php echo $atendimentoParaEditar['Nome_paciente']; ?>"><br>
                    <label class="label" for="Data_atendimento">Data de atendimento:</label><br>
                    <?php
                    if ($situacao == 'Ativo' || $situacao == 'Atrasado') {
                        echo "<input class='input' type='date' name='Data_atendimento' id='Data_atendimento' value='{$atendimentoParaEditar['Data_atendimento']}' readonly><br>";
                    } else {
                        echo "<input class='input' type='date' name='Data_atendimento' id='Data_atendimento' value='{$atendimentoParaEditar['Data_atendimento']}'><br>";
                    }  
                    ?>
                </div>  
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <label class="label" for="Horario_inicio">Horário de Inicio:</label><br>
                    <input class="input" type="time" name="Horario_inicio" id="Horario_inicio"  value="<?php echo $horarioInicio; ?>"><br>
                    <label class="label" for="Risco">Risco:</label><br>
                    <select class="input" name="Risco" id="Risco" required>
                        <option value="Baixo" <?php echo ($atendimentoParaEditar['Risco'] === 'Baixo') ? 'selected' : ''; ?>>Baixo</option>
                        <option value="Médio" <?php echo ($atendimentoParaEditar['Risco'] === 'Médio') ? 'selected' : ''; ?>>Médio</option>
                        <option value="Alto" <?php echo ($atendimentoParaEditar['Risco'] === 'Alto') ? 'selected' : ''; ?>>Alto</option>
                    </select><br>
                </div> 
                <div class="conjInput">
                    <label class="label" for="Retorno">É atendimento de retorno:</label><br>
                    <select class="input" name="Retorno" id="Retorno" required>
                        <option value="Sim" <?php echo ($atendimentoParaEditar['Retorno'] === 'Sim') ? 'selected' : ''; ?>>Sim</option>
                        <option value="Não" <?php echo ($atendimentoParaEditar['Retorno'] === 'Não') ? 'selected' : ''; ?>>Não</option>
                    </select><br>
                    <label class="label" for="CPF_paciente">CPF do Paciente:</label><br>
                    <input class="input" type="text" name="CPF_paciente" id="CPF_paciente" readonly value="<?php echo $atendimentoParaEditar['CPF_paciente']; ?>"><br>
                    <label class="label" for="Email_paciente">Email do Paciente:</label><br>
                    <input class="input" type="text" readonly name="Email_paciente" id="Email_paciente" value="<?php echo $emailPaciente; ?>"><br>
                </div> 
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <label class="label" for="Observacao">Observação:</label><br>
                    <textarea class="input" name="Observacao" id="Observacao" cols="20" rows="8"><?php echo $atendimentoParaEditar['Observacao']; ?></textarea><br>
                </div> 
                <div class="conjInput">
                    <label class="label" for="Responsavel_legal">Responsavel legal do paciente:</label><br>
                    <input class="input" type="text" name="Responsavel_legal" id="Responsavel_legal" readonly value="<?php echo $atendimentoParaEditar['Responsavel_legal']; ?>"><br>
                    <label for="Setor">Setor:</label><br>
                    <input class="label" class="input" type="text" name="Setor" id="Setor" readonly value="<?php echo $setorDoServico; ?>"><br> 
                    <label class="label" for="Protocolo">Protocolo:</label><br>
                    <input class="input" type="text" name="Protocolo" id="Protocolo" value='<?php echo($protocolo); ?>' readonly><br>
                </div> 
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <input type="hidden" name="ID_servico" id="ID_servico" value="<?php echo $atendimentoParaEditar['ID_servico']; ?>">
                    <input type="hidden" name="ID_paciente" id="ID_paciente" value="<?php echo $atendimentoParaEditar['ID_paciente']; ?>">
                    <input type="hidden" name="ID_profResponsavel" id="ID_profResponsavel" value="<?php echo $atendimentoParaEditar['ID_profResponsavel']; ?>">
                    <input type="hidden" name="ID_clinica" id="ID_clinica" value="<?php echo $_SESSION['ID_clinica']; ?>">
                    <input type="hidden" name="Situacao" id="Situacao" value="<?php echo $atendimentoParaEditar['Situacao']; ?>">
                </div> 
            </div>
            <div class="enviarAtd">  
                <input type="submit" value="Confirmar">
            </div>
            <div id="dadosClinica" data-dados='<?php echo json_encode($dadosClinica); ?>' style="display: none;"></div>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtém os dados da clínica do atributo data-dados
            var dadosClinica = JSON.parse(document.getElementById('dadosClinica').getAttribute('data-dados'));
            var campoPaciente = document.getElementById('Paciente');
            var campoIDPaciente = document.getElementById('ID_paciente');
            var campoServico = document.getElementById('Servico');
            var campoIDServico = document.getElementById('ID_servico');
            var campoProfResponsavel = document.getElementById('Prof_responsavel');
            var campoIDProfResponsavel  = document.getElementById('ID_profResponsavel');
            var labelProfResponsavel = document.getElementById('LabelProf_responsavel');
            var campoSetor = document.getElementById('Setor');
            var campoData = document.getElementById('Data_atendimento');

            // Armazena a última data válida
            var ultimaDataValida = campoData.value;

            campoData.addEventListener('change', function() {
                var dataEscolhida = new Date(this.value + 'T00:00:00');
                var dataAtual = new Date();
                dataAtual.setHours(0, 0, 0, 0); // Configurando horas, minutos, segundos e milissegundos para zero

                // Comparando as datas
                if (dataEscolhida < dataAtual) {
                    // Se a data escolhida for anterior à data atual, redefine a data de volta para a última data válida
                    this.value = ultimaDataValida;
                } else {
                    // Se a data escolhida for válida, atualiza a última data válida
                    ultimaDataValida = this.value;
                }
            });

            // Adiciona um ouvinte de evento para o campo Prof_responsavel
            campoProfResponsavel.addEventListener('change', function () {
                // Obtém o valor selecionado no campo Prof_responsavel
                var selectedProfissional = campoProfResponsavel.value;

                // Se o profissional selecionado não for vazio
                if (selectedProfissional !== '') {
                    // Obtém o ID do profissional selecionado
                    var selectedProfissionalId = campoProfResponsavel.options[campoProfResponsavel.selectedIndex].getAttribute('data-id');

                    // Atribui o ID do profissional ao campo ID_profResponsavel
                    campoIDProfResponsavel.value = selectedProfissionalId;
                } else {
                    // Se o profissional selecionado for vazio, limpa o campo ID_profResponsavel
                    campoIDProfResponsavel.value = '';
                }
            });
        });
    </script>
</body>
</html>
