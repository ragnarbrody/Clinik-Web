<?php
    //verifica se a sessão na pagina foi iniciada
    if(!isset($_SESSION))
    {
        //inicia a sessão com os dados armazenados em cache
        session_start();
    }

    //encerra a sessão do usuario, impedindo o mesmo de acessar ao sistema
    session_destroy();

    //envia o usuário para a pagina de login
    header("Location: index.php");
?>