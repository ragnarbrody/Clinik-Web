<?php
include('./protect.php');
include('./conexao.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário
    $Servico = $mysqli->real_escape_string($_POST['Servico']);
    $ID_servico = $mysqli->real_escape_string($_POST['ID_servico']);
    $Paciente = $mysqli->real_escape_string($_POST['Paciente']);
    $ID_paciente = $mysqli->real_escape_string($_POST['ID_paciente']);
    $Prof_responsavel = $mysqli->real_escape_string($_POST['Prof_responsavel']);
    $ID_profResponsavel = $mysqli->real_escape_string($_POST['ID_profResponsavel']);
    $ID_clinica = $mysqli->real_escape_string($_POST['ID_clinica']);
    $Data_atendimento = $mysqli->real_escape_string($_POST['Data_atendimento']);
    $Horario_inicio = $mysqli->real_escape_string($_POST['Horario_inicio']);
    $Risco = $mysqli->real_escape_string($_POST['Risco']);
    $Retorno = $mysqli->real_escape_string($_POST['Retorno']);
    $CPF_paciente = $mysqli->real_escape_string($_POST['CPF_paciente']);
    $Responsavel_legal = $mysqli->real_escape_string($_POST['Responsavel_legal']);
    $Setor = $mysqli->real_escape_string($_POST['Setor']);
    $Protocolo = $mysqli->real_escape_string($_POST['Protocolo']);
    $Email = $mysqli->real_escape_string($_POST['Email_paciente']);
    $Observacao = $mysqli->real_escape_string($_POST['Observacao']);
    $Valor = preg_replace("/[^0-9.]/", "", $_POST['valorServico']);

    // Converta para um número
    $Valor = floatval($Valor);
    //
    $dataAtual = strtotime(date('Y-m-d'));
    $dataAtendimentoTimestamp = strtotime($Data_atendimento);

    // Atribui um valor padrão à variável $Situacao
    $Situacao = "Ativo";

    // Realiza as verificações para determinar a situação
    if ($dataAtendimentoTimestamp > $dataAtual) {
        $Situacao = "Agendado";
    }

    // Insere os dados no banco de dados
    $sql = "INSERT INTO atendimentos (Servico, ID_servico, Nome_paciente, ID_paciente, Prof_responsavel, ID_profResponsavel, ID_clinica, Data_atendimento, Horario_inicio, Risco, Retorno, CPF_paciente, Responsavel_legal, Setor, Situacao, Observacao, Protocolo, valorServico) VALUES ('$Servico', '$ID_servico', '$Paciente', '$ID_paciente', '$Prof_responsavel', '$ID_profResponsavel', '$ID_clinica', '$Data_atendimento', '$Horario_inicio', '$Risco', '$Retorno', '$CPF_paciente', '$Responsavel_legal', '$Setor', '$Situacao', '$Observacao', '$Protocolo', '$Valor')";

    if ($mysqli->query($sql)) {
        // Verifica se a Situacao é "Agendado" antes de enviar o e-mail
        if ($Situacao == "Agendado"){

            //Data formatada para o envio de e-mails:
            $Data_atendimento_formatada = date("d/m/Y", strtotime($Data_atendimento));
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            try {
                //Configurações do servidor de email
                //Apenas para debug de desenvolvimento
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                //
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = $_SESSION['Email_clinica'];
                $mail->Password   = $_SESSION['Senha_email'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
            
                //Recipients
                $mail->setFrom($_SESSION['Email_clinica'], $_SESSION['Nome_clinica']);
                $mail->addAddress($Email, 'Paciente');     //Add a recipient
                $mail->addReplyTo($_SESSION['Email_clinica'], 'Clínica');
                //$mail->addCC('cc@example.com'); //E-mail em cópia
                //$mail->addBCC('bcc@example.com'); //Cópia oculta

                //Anexos        
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Adiciona anexos, nome é opcional
            
                //Conteúdo do email:
                $mail->CharSet = 'UTF-8';
                $mail->isHTML(true); //Email em formato HTML
                $mail->SetLanguage("br");

                if($Retorno == "Sim")
                {
                    $mail->Subject = 'AGENDAMENTO PARA RETORNO - Para o dia: '. $Data_atendimento_formatada . ', Confirmado! - ' . $_SESSION['Nome_clinica'];
                    $message = '<h1>Olá, ' . $Paciente . ',</h1><br>';
                    $message .= 'Seu agendamento de retorno foi confirmado para o dia: ' . $Data_atendimento_formatada . ',<br>';
                    $message .= 'Com horário de início estimado para às: ' . $Horario_inicio . ' horas, para o serviço: ' . $Servico . '.<br>';
                    $message .= 'Em caso de dúvidas, entre em contato com a clínica.<br><br>';
                    $message .= 'Atenciosamente, ' . $_SESSION['Nome_clinica'];
                }
                else
                {
                    $mail->Subject = 'AGENDAMENTO - Para o dia: '. $Data_atendimento_formatada . ', Confirmado! - ' . $_SESSION['Nome_clinica'];
                    $message = '<h1>Olá, ' . $Paciente . ',</h1><br>';
                    $message .= 'Seu agendamento foi confirmado para o dia: ' . $Data_atendimento_formatada . ',<br>';
                    $message .= 'Com horário de início estimado para às: ' . $Horario_inicio . ' horas, para o serviço: ' . $Servico . '.<br><br>';
                    $message .= 'Atenciosamente, ' . $_SESSION['Nome_clinica'];
                }
                
                $mail->Body = $message;
                $mail->Body = $message;
                $mail->AltBody = $message;

                $mail->send();
                echo '<script>
                    alert("Agendamento registrado e e-mail enviado com sucesso!");
                    window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
                </script>'; 
            } catch (Exception $e) {
                echo "A mensagem não pode ser enviada. Erro: {$mail->ErrorInfo}";
            }
        }
        else
        {
            echo '<script>
                alert("Atendimento registrado com sucesso!");
                window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
            </script>'; 
        }
    } else {
        echo "Erro ao registrar o atendimento: " . $mysqli->error;
    }
}
?>
