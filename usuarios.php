<?php
include('./conexao.php');
include('./protect.php');

// Consulta SQL para obter todos os registros de usuários
$sql_code = "SELECT * FROM usuarios";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

// Variável para armazenar a tabela HTML
$tabelaHTML = '';

// Verificar se há registros
if ($sql_query->num_rows > 0) {
    // Iniciar a tabela HTML
    $tabelaHTML .= '<table border="1">
            <tr>
                <th>ID</th>
                <th>Nickname</th>
                <th>Nome</th>
                <th>Cargo</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CRM</th>
                <th>Especialidade</th>
            </tr>';

    // Loop através dos registros e exibir em linhas da tabela
    while ($row = $sql_query->fetch_assoc()) {
        $tabelaHTML .= '<tr>';
        $tabelaHTML .= '<td>' . $row['id'] . '</td>';
        $tabelaHTML .= '<td>' . $row['nickname'] . '</td>';
        $tabelaHTML .= '<td>' . $row['nome'] . '</td>';
        $tabelaHTML .= '<td>' . $row['cargo'] . '</td>';
        $tabelaHTML .= '<td>' . $row['email'] . '</td>';
        $tabelaHTML .= '<td>' . $row['telefone'] . '</td>';
        $tabelaHTML .= '<td>' . $row['crm'] . '</td>';
        $tabelaHTML .= '<td>' . $row['especialidade'] . '</td>';
        $tabelaHTML .= '<td><button class="editar-btn" onclick="showModal(' . $row["id"] . ')">Editar</button></td>';
        $tabelaHTML .= '<td>' . '<button class="excluir-btn" data-id="' . $row["id"] . '">Excluir</button>' . '</td>';
        // Adicione mais colunas conforme necessário
        // Exemplo: echo '<td>' . $row['outra_coluna'] . '</td>';
        $tabelaHTML .= '</tr>';
    }

    // Fechar a tabela HTML
    $tabelaHTML .= '</table>';
} else {
    $tabelaHTML .= 'Nenhum usuário cadastrado.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/comum.css">
    <link rel="stylesheet" href="./styles/usuarios.css">
    <script src="https://kit.fontawesome.com/cf6fa412bd.js" crossorigin="anonymous"></script>
    <script src="./scripts/conteudoMenu.js"></script>
    <title>Home</title>
    <style>
        /*Códigos Css para o modal de editar usuario*/ 
            /* Estilo do modal */
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
            }

            /* Conteúdo do modal */
            .modal-content {
                background-color: #fff;
                margin: 10% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
            }

            /* Botão para fechar o modal */
            .close-btn {
                display: block;
                text-align: right;
                font-size: 24px;
                cursor: pointer;
            }

        /*códigos CSS para o modal de cadastro*/
            #cadastrarUser {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
            }
            #cadastrarUser .modal-content {
                background-color: #fff;
                margin: 10% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
            }
            #cadastrarUser .close-btn {
                display: block;
                text-align: right;
                font-size: 24px;
                cursor: pointer;
            }
    </style>
</head>
<body>
    <div class="conteudo pagina-conteudo">
        <div id="tabelaDiv">
            <h2>Usuários</h2>
            <?php echo $tabelaHTML; ?>   
            <div class="btnsTabela">
                <button onclick="openTesteModal()">Cadastrar</button>
            </div>     
        </div>
        <div class="modal">
            <div class="modal-content" id="editarUser">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <iframe src="editar_usuario.php" width="100%" height="400"></iframe>
            </div>
        </div>
        <div class="modal" id="cadastrarUser">
            <div class="modal-content">
                <span class="close-btn" onclick="closeTesteModal()">&times;</span>
                <iframe id="testeIframe" src="" width="100%" height="400"></iframe>
            </div>
        </div>
    </div>
    <script>
        //Funções para o modal de cadastrar usuário
            function openTesteModal() {
                var modal = document.getElementById('cadastrarUser');
                var iframe = document.getElementById('testeIframe');
                iframe.src = 'cadastrar_usuario.php';
                modal.style.display = 'block';
            }

            function closeTesteModal() {
                var modal = document.getElementById('cadastrarUser');
                modal.style.display = 'none';
            }
            // Função para fechar o modal e recarregar a página pai
            function closeModalAndReload() {
                var modal = document.getElementById('cadastrarUser');
                modal.style.display = 'none';
                location.reload(); // Recarrega a página pai
            }
        //------------------------------------------//
        //Funções para o modal de edição de usuários
            // Função para mostrar o modal e passar o ID do usuário
            function showModal(userId) {
                var modal = document.querySelector('.modal');
                var iframe = document.querySelector('iframe');
                iframe.src = 'editar_usuario.php?id=' + userId;
                modal.style.display = 'block';
            }

            // Função para fechar o modal
            function closeModal() {
                var modal = document.querySelector('.modal');
                modal.style.display = 'none';
            }
            // Função para fechar o modal e recarregar a página pai
            function closeModalAndReload() {
                var modal = document.querySelector('.modal');
                modal.style.display = 'none';
                location.reload(); // Recarrega a página pai
            }
        //------------------------------------------//    
        // Fecha o modal quando o usuário clica fora dele
        window.addEventListener("click", function(event) {
            var modal = document.querySelector('.modal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });

        window.addEventListener("click", function(event) {
            var testeModal = document.getElementById('cadastrarUser');
            if (event.target == testeModal) {
                closeTesteModal(); // Chame a função para fechar o modal de teste.php
            }
        });
        //Código para excluir o usuário
            //evento de clique aos botões "Excluir" com a classe "excluir-btn"
            var excluirButtons = document.querySelectorAll('.excluir-btn');
            excluirButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var userId = this.getAttribute('data-id');
                    var confirmDelete = confirm('Tem certeza de que deseja excluir este usuário?');
                    
                    if (confirmDelete) {
                        var userId = this.getAttribute('data-id'); 
                        // Faz uma solicitação para o arquivo PHP de exclusão
                        fetch('excluir_usuario.php?id=' + userId, {
                            method: 'GET' // Você pode usar POST em vez de GET, dependendo de sua preferência
                        })
                        .then(response => response.text())
                        .then(data => {
                            // Manipula a resposta do servidor após a exclusão
                            alert(data); // A resposta deve ser a mensagem do PHP (exemplo: "Usuário com ID X foi excluído com sucesso.")
                            
                            // Recarregar a página ou tomar outras ações necessárias
                            location.reload();
                        })
                        .catch(error => {
                            console.error('Erro ao excluir o usuário:', error);
                        });
                    }
                });
            });
        //--------------------------------------------//
    </script>
</body>
</html>