<?php
//verifica se a sessão foi iniciada na página
if(!isset($_SESSION))
{
    //inicia a sessão
    session_start();
}

//verifica se o usuário fez login a partir da analisa da variavel "ID" dentro de $_SESSION
if(!isset($_SESSION['id']))
{
    //envia o usuário para a pagina de login
    header("Location: index.php");
}

?>