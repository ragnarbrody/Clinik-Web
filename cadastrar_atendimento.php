<?php
session_start();
include('conexao.php');
include('protect.php');

// Chama a função para buscar dados com base no ID_clinica do usuário logado
$dadosClinica = buscarDadosClinica($_SESSION['ID_clinica']);

//Gera um protocolo aleatório que começa com 'P', seguido pelo timestamp atual e mais 1 caracter aleatório e depois mais 2 carácteres alphanuméricos aleatórios
$protocolo = 'P' . time() . substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 1) . substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 2);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/cadastrar_atendimento.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <title>Abertura de Atendimento</title>
</head>
<body>
    <div class="addAtd">
        <h2>Abertura de Atendimento</h2>
        <form action="processar_cadastroAtd.php" method="POST" class="form_addAtd">
            <div class="conteudoForm">
                <div class="conjInput">
                    <label for="Servico">Servico:</label>
                    <select name="Servico" id="Servico" required>
                        <option value=''></option>
                        <?php
                        foreach($dadosClinica['servicos'] as $servico) {
                            echo "<option value='{$servico['Servico']}' data-id='{$servico['ID']}'>{$servico['Servico']}</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="ID_servico" id="ID_servico" value="<?php echo $servico['ID']; ?>"><br>
                    <label for="Paciente">Paciente:</label><br>
                    <select name="Paciente" id="Paciente" required>
                        <option value=''></option>
                        <?php
                        foreach($dadosClinica['pacientes'] as $paciente) {
                            echo "<option value='{$paciente['nome_completo']}' data-id='{$paciente['ID']}'>{$paciente['nome_completo']}</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="ID_paciente" id="ID_paciente" value="<?php echo $paciente['ID']; ?>"><br>
                    <label id="LabelProf_responsavel" for="Prof_responsavel" style="display: none;">Profissional Responsável:</label>
                    <select name="Prof_responsavel" id="Prof_responsavel" required style="display: none;">
                        <option value=''></option>
                        <?php
                        foreach($dadosClinica['profissionais'] as $profissional) {
                            echo "<option value='{$profissional['Nome']}'>{$profissional['Nome']}</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="ID_profResponsavel" id="ID_profResponsavel" value="<?php echo $profissional['ID']; ?>"><br>
                    <input type="hidden" name="ID_clinica" id="ID_clinica" value="<?php echo $_SESSION['ID_clinica']; ?>"><br>
                </div>  
                <div class="conjInput">
                    <label for="Data_atendimento">Data de atendimento:</label>
                    <input type="date" name="Data_atendimento" id="Data_atendimento"><br>
                    <label for="Horario_inicio">Horário de Inicio:</label>
                    <input type="time" name="Horario_inicio" id="Horario_inicio"><br>
                    <label for="Risco">Risco:</label>
                    <select name="Risco" id="Risco" required>
                        <option value="Baixo">Baixo</option>
                        <option value="Médio">Médio</option>
                        <option value="Alto">Alto</option>
                    </select><br>
                </div> 
                <div class="conjInput">
                    <label for="Retorno">É atendimento de retorno:</label>
                    <select name="Retorno" id="Retorno" required>
                        <option value="Sim">Sim</option>
                        <option value="Não" selected>Não</option>
                    </select><br>
                    <label for="CPF_paciente">CPF do Paciente:</label>
                    <input type="text" name="CPF_paciente" id="CPF_paciente"><br>
                    <label for="Responsavel_legal">Responsavel legal do paciente:</label>
                    <input type="text" name="Responsavel_legal" id="Responsavel_legal"><br>
                </div> 
            </div>
            <div class="conteudoForm">
                <div class="conjInput">
                    <label for="Setor">Setor:</label>
                    <input type="text" name="Setor" id="Setor"><br> 
                    <input type="hidden" name="Situacao" id="Situacao" value="Ativo">
                    <label for="Protocolo">Protocolo:</label>
                    <input type="text" name="Protocolo" id="Protocolo" value='<?php echo($protocolo); ?>' readonly><br>
                </div> 
            </div>
            <div class="enviarAtd">  
                <input type="submit" value="Registrar">
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
            // Obtém a data atual
            var dataAtual = new Date();
            // Separa a data para eu poder formatar depois para o nosso padrão brasileiro: dia/mês/ano
            var dia = String(dataAtual.getDate()).padStart(2, '0');
            var mes = String(dataAtual.getMonth() + 1).padStart(2, '0'); // Mês começa do zero, então adicio 1 para garantir que pegará o mês atual
            var ano = dataAtual.getFullYear();
            var dataFormatada = dia + '/' + mes + '/' + ano;
            // Obtém a hora atual
            var horaAtual = ("0" + dataAtual.getHours()).slice(-2) + ":" + ("0" + dataAtual.getMinutes()).slice(-2);

            // Define o valor do campo de data no formato "yyyy-MM-dd" pois ele precisa ser deste formata para ser interpretado
            document.getElementById('Data_atendimento').value = ano + '-' + mes + '-' + dia;
            // Define o valor do campo de data no formato "dd/MM/yyyy" para exibição
            document.getElementById('Data_atendimento').textContent = dataFormatada;
            document.getElementById("Horario_inicio").value = horaAtual;

            // Adiciona um ouvinte de evento para o campo Servico
            campoServico.addEventListener('click', function () {
                // Obtém o valor selecionado no campo Servico
                var selectedServico = campoServico.value;

                // Se o serviço selecionado não for vazio
                if (selectedServico !== '') {
                    // Exibe o campo Prof_responsavel
                    campoProfResponsavel.style.display = 'block';
                    labelProfResponsavel.style.display = 'block';

                    // Obtém o ID do serviço selecionado
                    var selectedServicoId = campoServico.options[campoServico.selectedIndex].getAttribute('data-id');
                    // Atribui o ID do serviço ao campo ID_servico
                    campoIDServico.value = selectedServicoId;

                    // Preenche automaticamente o campo Setor com o valor correspondente ao serviço selecionado
                    var setorDoServico = null;

                    for (var i = 0; i < dadosClinica.servicos.length; i++) {
                        if (dadosClinica.servicos[i].Servico === selectedServico) {
                            setorDoServico = dadosClinica.servicos[i].Especialidade;
                            break;
                        }
                    }

                    // Preenche o campo Prof_responsavel apenas com os especialistas do setor correspondente ao serviço selecionado
                    campoProfResponsavel.innerHTML = ''; // Limpa as opções existentes

                    // Obtém os dados dos profissionais da clínica
                    var profissionais = dadosClinica.profissionais;

                    // Filtra os profissionais que são especialistas e pertencem ao mesmo setor do serviço selecionado
                    var profEspecialistas = profissionais.filter(function (profissional) {
                        return profissional.Setor === setorDoServico;
                    });

                    // Adiciona as opções ao campo Prof_responsavel
                    profEspecialistas.forEach(function (profissional) {
                        var option = document.createElement('option');
                        option.value = profissional.Nome;
                        option.textContent = profissional.Nome;
                        option.setAttribute('data-id', profissional.ID); // Adiciona o ID do profissional como um atributo data
                        campoProfResponsavel.appendChild(option)
                    });

                    // Preenche o campo ID_profResponsavel com o ID do primeiro profissional
                    if (profEspecialistas.length > 0) {
                        campoIDProfResponsavel.value = profEspecialistas[0].ID;
                    } else {
                        // Se não houver profissionais, limpa o campo ID_profResponsavel
                        campoIDProfResponsavel.value = '';
                    }

                    if (setorDoServico !== null) {
                        campoSetor.value = setorDoServico;
                    } else {
                        console.error("Setor não encontrado para o serviço selecionado.");
                        campoSetor.value = ''; // Limpa o campo Setor em caso de erro
                    }
                    
                } else {
                    // Se o serviço selecionado for vazio, esconde o campo Prof_responsavel
                    campoProfResponsavel.style.display = 'none';
                    labelProfResponsavel.style.display = 'none';
                    campoSetor.value = '';
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

            // Adiciona um ouvinte de evento para o campo Paciente
            campoPaciente.addEventListener('change', function () {
                // Obtém o valor selecionado no campo Paciente
                var selectedPaciente = campoPaciente.value;

                // Se o paciente selecionado não for vazio
                if (selectedPaciente !== '') {
                    // Obtém o ID do serviço selecionado
                    var selectedPacienteId = campoPaciente.options[campoPaciente.selectedIndex].getAttribute('data-id');
                    // Atribui o ID do serviço ao campo ID_servico
                    campoIDPaciente.value = selectedPacienteId;

                    // Obtém os dados do paciente selecionado
                    var pacienteSelecionado = dadosClinica.pacientes.find(function (paciente) {
                        return paciente.nome_completo === selectedPaciente;
                    });

                    // Preenche os campos CPF_paciente e Responsavel_legal com os dados do paciente
                    if (pacienteSelecionado) {
                        document.getElementById('CPF_paciente').value = pacienteSelecionado.CPF;
                        document.getElementById('Responsavel_legal').value = pacienteSelecionado.responsavel_legal;
                    } else {
                        console.error("Dados do paciente não encontrados.");
                    }
                } else {
                    // Se o paciente selecionado for vazio, limpa os campos CPF_paciente e Responsavel_legal
                    document.getElementById('CPF_paciente').value = '';
                    document.getElementById('Responsavel_legal').value = '';
                }
            });
        });
    </script>
</body>
</html>
