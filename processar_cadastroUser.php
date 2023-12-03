<?php
include('./protect.php');
include('./conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera os dados do formulário
    $nome = $mysqli->real_escape_string($_POST['nome']);
    $nacionalidade = $mysqli->real_escape_string($_POST['nacionalidade']);
    $setor = $mysqli->real_escape_string($_POST['setor']);
    $cargo = $mysqli->real_escape_string($_POST['cargo']);
    $crm = $mysqli->real_escape_string($_POST['crm']);
    $nick = $mysqli->real_escape_string($_POST['apelido']);
    $senha = $mysqli->real_escape_string($_POST['senha']);
    $especialidade = $mysqli->real_escape_string($_POST['especialidade']);
    $cpf = $mysqli->real_escape_string($_POST['cpf']);
    $rg = $mysqli->real_escape_string($_POST['rg']);
    $data_nascimento = $mysqli->real_escape_string($_POST['data_nascimento']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $telefone = $mysqli->real_escape_string($_POST['telefone']);
    // Armazena o ID_clinica do usuário logado
    $idClinica = $_SESSION['ID_clinica'];

    // Consulta para obter o plano da clínica
    $consultaPlano = "SELECT Plano, Users_Adicionais FROM clinicas WHERE ID = '$idClinica'";
    $resultadoPlano = $mysqli->query($consultaPlano);

    if ($resultadoPlano) {
        $dadosPlano = $resultadoPlano->fetch_assoc();
        $plano = $dadosPlano['Plano'];
        $usuariosAdicionais = $dadosPlano['Users_Adicionais'];

        // Define o limite de usuários permitido para o plano da clínica
        if ($plano === 'Basico') {
            $limiteUsuarios = 5 + $usuariosAdicionais;
        } elseif ($plano === 'Plus') {
            $limiteUsuarios = 12 + $usuariosAdicionais;
        } elseif ($plano === 'Personalizado') {
            $limiteUsuarios = PHP_INT_MAX; // Limite ilimitado para plano personalizado
        } else {
            echo "Plano da cliníca inválido.";
            exit;
        }

        // Consulta para contar o número de usuários existentes na clínica
        $consultaUsuarios = "SELECT COUNT(*) as total_usuarios FROM usuarios WHERE ID_clinica = '$idClinica'";
        $resultadoConsulta = $mysqli->query($consultaUsuarios);

        if ($resultadoConsulta) {
            $dadosConsulta = $resultadoConsulta->fetch_assoc();
            $totalUsuarios = $dadosConsulta['total_usuarios'];

            // Verifica se o número total de usuários (incluindo os usuários adicionais) atingiu o limite permitido
            if ($totalUsuarios >= $limiteUsuarios) 
            {
                echo '<script>
                alert("Limite de usuários atingido!");
                window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
                </script>';
            } 
            else 
            {
                if (isset($_FILES['foto'])){
                    $foto = $_FILES['foto'];
                    if ($foto['error'] === 0) {
                        $nomeFoto = $mysqli->real_escape_string($foto['name']);
                        $tamanhoFoto = $foto['size'];
                        $tipoFoto = $foto['type'];
                        $caminhoTemporario = $foto['tmp_name'];
                
                        // Verifica se o arquivo é uma imagem
                        if (strpos($tipoFoto, 'image') !== false) {
                            // Move a imagem para um diretório específico
                            $caminhoDestino = './Imagens/fotosPerfil/' . $nomeFoto;
                            move_uploaded_file($caminhoTemporario, $caminhoDestino);
                            $sql = "INSERT INTO usuarios (Nome, Nacionalidade, Setor, Cargo, CRM, Apelido, Senha, Especialidade, CPF, RG, Data_nascimento, Email, Telefone, ID_clinica, Foto) 
                            VALUES ('$nome', '$nacionalidade', '$setor', '$cargo', '$crm', '$nick', '$senha', '$especialidade', '$cpf', '$rg', '$data_nascimento', '$email', '$telefone', '$idClinica', '$caminhoDestino')";
                        } else {
                            echo '<script>
                                alert("Erro: O arquivo enviado não é uma imagem.");
                                window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
                            </script>';
                        }
                    }else{
                        $sql = "INSERT INTO usuarios (Nome, Nacionalidade, Setor, Cargo, CRM, Apelido, Senha, Especialidade, CPF, RG, Data_nascimento, Email, Telefone, ID_clinica) 
                        VALUES ('$nome', '$nacionalidade', '$setor', '$cargo', '$crm', '$nick', '$senha', '$especialidade', '$cpf', '$rg', '$data_nascimento', '$email', '$telefone', '$idClinica')";
                    }
                }
                // Insere o novo usuário no banco de dados
                if ($mysqli->query($sql)) {
                    echo '<script>
                        alert("Usuário cadastrado com sucesso!");
                        window.parent.closeModalAndReload(); // Chama a função do pai para fechar o modal e recarregar a página pai
                    </script>'; 
                } else {
                    echo "Erro ao cadastrar usuário: " . $mysqli->error;
                }
            }
        } else {
            echo "Erro ao consultar o número de usuários da clínica: " . $mysqli->error;
        }
    } else {
        echo "Erro ao consultar o plano da clínica: " . $mysqli->error;
    }  
}
?>
