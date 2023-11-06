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
                            echo "<option value='{$servico['ID']}'>{$servico['Servico']}</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="ID_servico" id="ID_servico" value=""><br>
                    <label for="Paciente">Paciente:</label><br>
                    <select name="Paciente" id="Paciente" required>
                        <option value=''></option>
                        <?php
                        foreach($dadosClinica['pacientes'] as $paciente) {
                            echo "<option value='{$paciente['ID']}'>{$paciente['nome_completo']}</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="ID_paciente" id="ID_paciente" value=""><br>
                    <label id="LabelProf_responsavel" for="Prof_responsavel" style="display: none;">Profissional Responsável:</label>
                    <select name="Prof_responsavel" id="Prof_responsavel" required style="display: none;">
                        <option value=''></option>
                        <?php
                        foreach($dadosClinica['profissionais'] as $profissional) {
                            echo "<option value='{$profissional['ID']}'>{$profissional['Nome']}</option>";
                        }
                        ?>
                    </select>
                    <input type="hidden" name="ID_profResponsavel" id="ID_profResponsavel" value=""><br>
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

            // Adiciona um evento de mudança ao campo de seleção de serviço
            campoServico.addEventListener('click', function() {
                // Obtém o valor selecionado do campo Paciente
                var idServicoSelecionado = this.value;
                // Atualiza o valor do campo hidden ID_paciente
                campoIDServico.value = idServicoSelecionado;

                // Obtém o serviço selecionado
                var servicoSelecionadoID = this.value;
                var servicoSelecionado = dadosClinica.servicos.find(servico => servico.ID === servicoSelecionadoID);

                // Define o valor do campo Setor com base no serviço selecionado
                if (servicoSelecionado) {
                    campoSetor.value = servicoSelecionado.Especialidade;

                    // Filtra os profissionais por setor igual à especialidade do serviço
                    var profissionaisEspecialistas = dadosClinica.profissionais.filter(profissional => profissional.Setor === servicoSelecionado.Especialidade);
                    
                    // Limpa o campo Prof_responsavel antes de adicionar as opções
                    campoProfResponsavel.innerHTML = '';

                    // Preenche o campo Prof_responsavel apenas com profissionais que atendem aos critérios
                    profissionaisEspecialistas.forEach(profissional => {
                        var option = document.createElement('option');
                        option.value = profissional.ID;
                        option.textContent = profissional.Nome;
                        campoProfResponsavel.appendChild(option);
                    });

                    // Torna o campo Prof_responsavel visível
                    campoProfResponsavel.style.display = 'block';
                    labelProfResponsavel.style.display = 'block';

                    // Obtém o ID_profResponsavel selecionado
                    var idProfissionalSelecionado = this.value;
                    // Atualiza o valor do campo hidden ID_profResponsavel
                    campoIDProfResponsavel.value = idProfissionalSelecionado;
                } else {
                    campoSetor.value = '';
                    // Limpa o campo Prof_responsavel se nenhum serviço estiver selecionado
                    campoProfResponsavel.innerHTML = '';
                    // Torna o campo Prof_responsavel invisível
                    campoProfResponsavel.style.display = 'none';
                    labelProfResponsavel.style.display = 'none';
                }
            });

            // Adiciona um evento de mudança ao campo de seleção de paciente
            var campoPaciente = document.getElementById('Paciente');
            var campoIDPaciente = document.getElementById('ID_paciente');
            campoPaciente.addEventListener('click', function() {
                // Obtém o valor selecionado do campo Paciente
                var idPacienteSelecionado = this.value;
                // Atualiza o valor do campo hidden ID_paciente
                campoIDPaciente.value = idPacienteSelecionado;

                // Obtém o paciente selecionado
                var pacienteSelecionado = this.options[this.selectedIndex].text;
                
                // Obtém o objeto do paciente selecionado
                var paciente = dadosClinica.pacientes.find(paciente => paciente.nome_completo === pacienteSelecionado);
                // Verifica se o paciente foi encontrado e se as propriedades CPF e responsavel_legal existem
                if (paciente.CPF && paciente.responsavel_legal) {
                    // Define os valores padrão para os campos de CPF e responsável legal
                    document.getElementById('CPF_paciente').value = paciente.CPF;
                    document.getElementById('Responsavel_legal').value = paciente.responsavel_legal;
                } else {
                    // Se as propriedades não existem, define os campos como 'Não encontrado'
                    document.getElementById('CPF_paciente').value = 'Não encontrado';
                    document.getElementById('Responsavel_legal').value = 'Não encontrado';
                }
            });
        });
    </script>
</body>
</html>
