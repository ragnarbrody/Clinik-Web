<?php
include('./conexao.php');

if(isset($_POST['usuario']) && isset($_POST['senha']))
{
    if(strlen($_POST['usuario']) == 0)
    {
        echo "Preencha seu nome de usuário";
    }
    else if(strlen($_POST['senha']) == 0)
    {
        echo "Preencha sua senha";
    }
    else
    {
        $nickname = $mysqli->real_escape_string($_POST['usuario']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT u.*, c.* FROM usuarios u
                     JOIN clinicas c ON u.ID_clinica = c.ID
                     WHERE u.Apelido = '$nickname' AND u.Senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1)
        {
            $usuario = $sql_query->fetch_assoc();

            $sql_idUser = "SELECT ID FROM usuarios WHERE Apelido = '$nickname' AND Senha = '$senha'";
            $sql_queryUser = $mysqli->query($sql_idUser) or die("Falha na execução do código SQL: " . $mysqli->error);
            $idUser = $sql_queryUser->fetch_assoc();

            if(!isset($_SESSION))
            {
                session_start();
            }
            
            // Verificar se a coluna 'ID' está definida antes de acessá-la
            if (isset($usuario['ID'])) {
                // Dados do usuário
                $_SESSION['id'] = $idUser['ID'];
                $_SESSION['nome'] = $usuario['Nome'];
                $_SESSION['cargo'] = $usuario['Cargo'];
                $_SESSION['email'] = $usuario['Email'];
                $_SESSION['apelido'] = $usuario['Apelido'];
                $_SESSION['telefone'] = $usuario['Telefone'];
                $_SESSION['crm'] = $usuario['Crm'];
                $_SESSION['especialidade'] = $usuario['Especialidade'];
                $_SESSION['ID_clinica'] = $usuario['ID_clinica'];
                $_SESSION['Foto'] = $usuario['Foto'];
                $_SESSION['Data_nascimento'] = $usuario['Data_nascimento'];
                $_SESSION['Nacionalidade'] = $usuario['Nacionalidade'];
                $_SESSION['Setor'] = $usuario['Setor'];
                $_SESSION['CPF'] = $usuario['CPF'];
                $_SESSION['RG'] = $usuario['RG'];

                // Dados da clínica
                $_SESSION['Nome_clinica'] = $usuario['Nome_clinica'];
                $_SESSION['Email_clinica'] = $usuario['Email_clinica'];
                $_SESSION['Senha_email'] = $usuario['Senha_email'];
                $_SESSION['Logradouro'] = $usuario['Logradouro'];
                $_SESSION['Cidade'] = $usuario['Cidade'];

                header("Location: menuPrincipal.php");
            } else {
                echo "Erro: Coluna 'ID' não encontrada no resultado da consulta.";
            }
        }
        else
        {
            echo "Falha ao logar, usuário ou senha incorretos!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./styles/header.css">
        <link rel="stylesheet" href="./styles/login.css">
        <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
        <title>Login</title>
    </head>
    <body>
        <header>
            <div class="Logo Icon">
                <img src="./Imagens/Logo.png" alt="Logo do aplicativo Clinik Flow" class="Clinik">
                <img src="./Imagens/Linhas.png" alt="" class="Linhas">
            </div>
            <div class="Logo nomeSlogan">
                <img src="./Imagens/Clinik.png" alt="Nome do aplicativo Clinik Flow" class="Nome">
            </div>
        </header>
        <main>
            <form action="" method="POST" class="formLogin">
                <img src="./Imagens/LoginTitle.png" alt="Nome do aplicativo Clinik Flow" class="Titulo">
                <div class="Input">
                    <i class="fas fa-user iUser"></i>
                    <input type="text" placeholder="Usuario" required class="Text User" name="usuario">
                </div>
                <div class="Input">
                    <i class="fas fa-lock iPassword"></i>
                    <input type="password" placeholder="Senha" required class="Text Senha" name="senha">                  
                </div>              
                <button type="submit" class="btn btn-one">
                    <span>LOGAR</span>
                </button>                            
            </form>
        </main>
        <footer>
            <div class="Logo Icon">
                <img src="./Imagens/Logo.png" alt="Logo do aplicativo Clinik Flow" class="Clinik">
            </div> 
        </footer>      
        <script src="./scripts/index.js"></script>
    </body>
</html>