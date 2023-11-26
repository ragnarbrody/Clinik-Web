<?php
include('./conexao.php');
include('./protect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
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
    $sql_select = "SELECT Situacao FROM atendimentos WHERE Protocolo = $prtAtendimento";
    $result = $mysqli->query($sql_select);

    // Verifica se a consulta foi bem-sucedida
    if ($result) {
        $row = $result->fetch_assoc();
        $situacaoAtual = $row['Situacao'];

        if($situacaoAtual == 'Agendado')
        {
            $novaSituacao = 'Cancelado';
            //Data formatada para o envio de e-mails:
            $Data_atendimento_formatada = date("d/m/Y", strtotime($dataAtual));
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            try {
                //Configurações do servidor de email
                //Apenas para debug de desenvolvimento
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
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
                $mail->Subject = 'CANCELAMENTO - Agendamento para o dia: '. $Data_atendimento_formatada . ', <strong>Cancelado!</strong> - ' . $_SESSION['Nome_clinica'];
                $message = '<h1>Olá, ' . $Paciente . ',</h1><br>';
                $message .= 'Seu agendamento para o dia: ' . $Data_atendimento_formatada . ', e para o serviço: ' . $Servico . ', foi <strong>cancelado!</strong><br>';
                $message .= 'Verifique com a clínica o motivo do cancelamento e como proceder!<br><br>';
                $message .= 'Atenciosamente,' . $_SESSION['Nome_clinica'];
                
                $mail->Body = $message;
                $mail->Body = $message;
                $mail->AltBody = $message;

                $mail->send();
            } catch (Exception $e) {
                echo "A mensagem não pode ser enviada. Erro: {$mail->ErrorInfo}";
            }
        }
        else
        {
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
        // Se houver um erro na seleção
        echo "Falha ao obter a situação do atendimento com protocolo $prtAtendimento: " . $mysqli->error;
    }
} else {
    // Se o ID do usuário não foi fornecido na solicitação
    echo 'Protocolo de atendimento não fornecido.';
}
?>