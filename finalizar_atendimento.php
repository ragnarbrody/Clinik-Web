<?php
include('./conexao.php');
include('./protect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require './vendor/autoload.php';

// Verifica se o protocolo do atendimento foi fornecido
if (isset($_GET['Protocolo'])) {
    $prtAtendimento = $_GET['Protocolo'];
    $motivo = $_GET['Motivo'];

    // Define o fuso horário
    date_default_timezone_set('America/Sao_Paulo');
    // Obtém a data e hora atuais
    $dataAtual = date('Y-m-d');
    $horaAtual = date('H:i:s');

    // Consulta SQL para obter o valor atual da coluna "Situacao"
    $sql_situacao = "SELECT Situacao FROM atendimentos WHERE Protocolo = $prtAtendimento";
    $result_situacao = $mysqli->query($sql_situacao);

    // Verifica se a consulta foi bem-sucedida
    if ($result_situacao) {
        $row_situacao = $result_situacao->fetch_assoc();
        $situacaoAtual = $row_situacao['Situacao'];

        // Consulta SQL para obter o e-mail e o nome completo do paciente
        $sql_paciente = "SELECT email, nome_completo FROM paciente WHERE ID = (SELECT ID_paciente FROM atendimentos WHERE Protocolo = $prtAtendimento)";
        $result_paciente = $mysqli->query($sql_paciente);

        // Verifica se a consulta foi bem-sucedida
        if ($result_paciente) {
            $row_paciente = $result_paciente->fetch_assoc();
            $Email = $row_paciente['email'];
            $Paciente = $row_paciente['nome_completo'];

            // Consulta SQL para obter o serviço relacionado
            $sql_servico = "SELECT Servico FROM servicos WHERE ID = (SELECT ID_servico FROM atendimentos WHERE Protocolo = $prtAtendimento)";
            $result_servico = $mysqli->query($sql_servico);

            // Verifica se a consulta foi bem-sucedida
            if ($result_servico) {
                $row_servico = $result_servico->fetch_assoc();
                $Servico = $row_servico['Servico'];

                if ($situacaoAtual == 'Agendado') {
                    $novaSituacao = 'Cancelado';
                    //Data formatada para o envio de e-mails:
                    $Data_atendimento_formatada = date("d/m/Y", strtotime($dataAtual));
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
                        $mail->Subject = 'CANCELAMENTO - Agendamento para o dia: '. $Data_atendimento_formatada . ', Cancelado! - ' . $_SESSION['Nome_clinica'];
                        $message = '<h1>Olá, ' . $Paciente . ',</h1><br>';
                        $message .= 'Seu agendamento para o dia: ' . $Data_atendimento_formatada . ', e para o serviço: ' . $Servico . ', foi <b>cancelado!</b><br>';
                        $message .= 'Verifique com a clínica o motivo do cancelamento e como proceder!<br><br>';
                        $message .= 'Atenciosamente, ' . $_SESSION['Nome_clinica'];
                        
                        $mail->Body = $message;
                        $mail->Body = $message;
                        $mail->AltBody = $message;

                        $mail->send();
                    } catch (Exception $e) {
                        echo "A mensagem não pode ser enviada. Erro: {$mail->ErrorInfo}";
                    }
                } else {
                    $novaSituacao = 'Finalizado';
                }

                // Consulta SQL para atualizar os campos desejados
                $sql_code = "UPDATE atendimentos 
                SET Situacao = '$novaSituacao', 
                    Horario_saida = '$horaAtual', 
                    Data_finalizado = '$dataAtual',
                    Motivo_canc = '$motivo' 
                WHERE Protocolo = $prtAtendimento";

                // Executa a consulta
                if ($mysqli->query($sql_code)) {
                    // A atualização foi bem-sucedida
                    echo "Atendimento de protocolo $prtAtendimento foi $novaSituacao com sucesso.";
                } else {
                    // Se houver um erro na atualização
                    echo "Falha ao finalizar o atendimento com protocolo $prtAtendimento: " . $mysqli->error;
                }
            } else {
                // Se houver um erro na consulta do serviço
                echo "Falha ao obter o serviço relacionado ao atendimento com protocolo $prtAtendimento: " . $mysqli->error;
            }
        } else {
            // Se houver um erro na consulta do e-mail
            echo "Falha ao obter o e-mail do paciente para o atendimento com protocolo $prtAtendimento: " . $mysqli->error;
        }
    } else {
        // Se houver um erro na consulta da situação
        echo "Falha ao obter a situação do atendimento com protocolo $prtAtendimento: " . $mysqli->error;
    }
} else {
    // Se o ID do usuário não foi fornecido na solicitação
    echo 'Protocolo de atendimento não fornecido.';
}
?>