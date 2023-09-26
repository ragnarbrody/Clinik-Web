<?php
session_start();
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

        $sql_code = "SELECT * FROM usuarios WHERE nickname = '$nickname' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1)
        {
            $usuario = $sql_query->fetch_assoc();

            if(!isset($_SESSION))
            {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['cargo'] = $usuario['cargo'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['nickname'] = $usuario['nickname'];
            $_SESSION['telefone'] = $usuario['telefone'];
            $_SESSION['crm'] = $usuario['crm'];
            $_SESSION['especialidade'] = $usuario['especialidade'];

            header("Location: menuPrincipal.php");
        }
        else
        {
            $_SESSION['nao_autenticado'] =true;
            header('location: index.php');
            exist();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <p class="Slogan">O software que leva eficiência à sua clínica</p>
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
                <?php
                if  (isset($_SESSION['nao_autenticado'])):
                 ?> 
                <div class="lerro"> 
                    <p><b>falha ao logar, usuario ou senha incorreto<b>
                    </P>

                </div>
                <?php
                unset($_SESSION['nao_autenticado']);
                endif;
                ?>
                          
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