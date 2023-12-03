<?php
session_start();
include('conexao.php');
include('protect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $ID_servico = $_POST['ID_servico'];
    $ID_paciente = $_POST['ID_paciente'];
    $ID_profResponsavel = $_POST['ID_profResponsavel'];
    $ID_clinica = $_POST['ID_clinica'];
    $Situacao = $_POST['Situacao'];
    $Servico = $_POST['Servico'];
    $Prof_responsavel = $_POST['Prof_responsavel'];
    $Paciente = $_POST['Paciente'];
    $Data_atendimento = $_POST['Data_atendimento'];
    $Horario_inicio = $_POST['Horario_inicio'];
    $Risco = $_POST['Risco'];
    $Retorno = $_POST['Retorno'];
    $CPF_paciente = $_POST['CPF_paciente'];
    $Observacao = $_POST['Observacao'];
    $Responsavel_legal = $_POST['Responsavel_legal'];
    $Setor = $_POST['Setor'];
    $Protocolo = $_POST['Protocolo'];

    // Verifica se a Situacao é "Agendado" antes de enviar o e-mail
    if ($Situacao == "Agendado"){

        // Consulta SQL para obter a data anterior do atendimento
        $sqlDataHoraAnterior = "SELECT Data_atendimento, Horario_inicio FROM atendimentos WHERE Protocolo = '$Protocolo'";
        $resultDataHoraAnterior = $mysqli->query($sqlDataHoraAnterior);

        if ($resultDataHoraAnterior) {
            $row_dataHora = $resultDataHoraAnterior->fetch_assoc();
            $dataAnterior = $row_dataHora['Data_atendimento'];
            $horaAnterior = $row_dataHora['Horario_inicio'];

            // Atualiza os dados no banco de dados
            $sqlAtualizarAtendimento = "UPDATE atendimentos SET
                ID_servico = '$ID_servico',
                ID_paciente = '$ID_paciente',
                ID_profResponsavel = '$ID_profResponsavel',
                ID_clinica = '$ID_clinica',
                Situacao = '$Situacao',
                Servico = '$Servico',
                Prof_responsavel = '$Prof_responsavel',
                Nome_paciente = '$Paciente',
                Data_atendimento = '$Data_atendimento',
                Horario_inicio = '$Horario_inicio',
                Risco = '$Risco',
                Retorno = '$Retorno',
                CPF_paciente = '$CPF_paciente',
                Observacao = '$Observacao',
                Responsavel_legal = '$Responsavel_legal',
                Setor = '$Setor'
                WHERE Protocolo = '$Protocolo'";

            if ($mysqli->query($sqlAtualizarAtendimento) === TRUE) {
                $horaAnteriorFormatada = date('H:i', strtotime($horaAnterior));
                $horarioInicioFormatado = date('H:i', strtotime($Horario_inicio));
                // Verifica se a data foi alterada
                if ((date("Y-m-d", strtotime($dataAnterior)) != date("Y-m-d", strtotime($Data_atendimento))) || ($horaAnteriorFormatada != $horarioInicioFormatado)) {
                    // Consulta SQL para obter o email do paciente
                    $sqlEmailPaciente = "SELECT email FROM paciente WHERE ID = (SELECT ID_paciente FROM atendimentos WHERE Protocolo = '$Protocolo')";
                    $resultEmailPaciente = $mysqli->query($sqlEmailPaciente);

                    // Verifica se a consulta foi bem-sucedida
                    if ($resultEmailPaciente !== false) {
                        // Verifica se há pelo menos uma linha retornada
                        if ($resultEmailPaciente->num_rows > 0) {
                            $emailPaciente = $resultEmailPaciente->fetch_assoc()['email'];
                        } else {
                            // Trata o caso em que não há resultados
                            echo "Email do paciente não encontrado.";
                            exit;
                        }
                    } else {
                        // Trata o caso em que houve um erro na consulta SQL
                        echo "Erro na consulta SQL: " . $mysqli->error;
                        exit;
                    }
                    
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
                        $mail->addAddress($emailPaciente, 'Paciente');     //Add a recipient
                        $mail->addReplyTo($_SESSION['Email_clinica'], 'Clínica');
                        //$mail->addCC('cc@example.com'); //E-mail em cópia
                        //$mail->addBCC('bcc@example.com'); //Cópia oculta

                        //Anexos        
                        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Adiciona anexos, nome é opcional

                        //Conteúdo do email:
                        $mail->CharSet = 'UTF-8';
                        $mail->isHTML(true); //Email em formato HTML
                        $mail->SetLanguage("br");
                        $mail->Subject = 'ALTERAÇÃO - Agendamento para o dia: '. date('d/m/Y', strtotime($dataAnterior)) . ', alterado! - ' . $_SESSION['Nome_clinica'];
                        $message = '<h1>Olá, ' . $Paciente . ',</h1><br>';
                        $message .= 'Seu agendamento para o dia: ' . date('d/m/Y', strtotime($dataAnterior)) . ', com início para às: '. $horaAnteriorFormatada .', e para o serviço: ' . $Servico . ', foi <b>alterado!</b><br>';
                        $message .= 'A nova data para seu agendamento agora é para o dia: <strong>'. date('d/m/Y', strtotime($Data_atendimento)) .'</strong> e hora de início para às: <strong>'. $horarioInicioFormatado .'</strong><br>';
                        $message .= 'Verifique com a clínica como proceder!<br><br>';
                        $message .= 'Atenciosamente, ' . $_SESSION['Nome_clinica'];
                        
                        $mail->Body = $message;
                        $mail->Body = $message;
                        $mail->AltBody = $message;

                        $mail->send();
                    } catch (Exception $e) {
                        echo "A mensagem não pode ser enviada. Erro: {$mail->ErrorInfo}";
                    }
                    echo '<script>
                        alert("Agendamento atualizado e e-mail enviado com sucesso!");
                        window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
                    </script>';
                } else {
                    echo '<script>
                        alert("Agendamento atualizado com sucesso!");
                        window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
                    </script>';
                }
            } else {
                echo "Erro ao atualizar atendimento: " . $mysqli->error;
            }
        } else {
            echo "Erro ao obter a data anterior do atendimento: " . $mysqli->error;
        }
    }else if ($Situacao == "Ativo") {
        // Atualiza os dados no banco de dados
        $sqlAtualizarAtendimento = "UPDATE atendimentos SET
        ID_servico = '$ID_servico',
        ID_paciente = '$ID_paciente',
        ID_profResponsavel = '$ID_profResponsavel',
        ID_clinica = '$ID_clinica',
        Situacao = '$Situacao',
        Servico = '$Servico',
        Prof_responsavel = '$Prof_responsavel',
        Nome_paciente = '$Paciente',
        Data_atendimento = '$Data_atendimento',
        Horario_inicio = '$Horario_inicio',
        Risco = '$Risco',
        Retorno = '$Retorno',
        CPF_paciente = '$CPF_paciente',
        Observacao = '$Observacao',
        Responsavel_legal = '$Responsavel_legal',
        Setor = '$Setor'
        WHERE Protocolo = '$Protocolo'";

        if ($mysqli->query($sqlAtualizarAtendimento) === TRUE) {
            echo '<script>
                alert("Atendimento atualizado com sucesso!");
                window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
            </script>';
        } else {
            echo "Erro ao atualizar atendimento: " . $mysqli->error;
        }
    }else if ($Situacao == "Atrasado") {
        echo '<script>
            alert("Não é possível alterar um atendimento \'Atrasado\', finalize-o e inicie um novo atendimento");
            window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
        </script>';
    }else{
        echo '<script>
            alert("Situacao desconhecida!");
        </script>';
    }
} else {
    echo "Método não permitido";
}
?>