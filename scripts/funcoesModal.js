//Funções gerais
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
    // Fecha o modal quando o usuário clica fora dele
    window.addEventListener("click", function(event) {
        var modal = document.querySelector('.modal');
        if (event.target == modal) {
            closeModal();
        }
    });    

//---------------------------------//

//Funções para a tela de usuarios
    //Funções para o modal de cadastrar usuário
    function openModalReg() {
        var modal = document.querySelector('.modal');
        var iframe = document.querySelector('iframe');
        iframe.src = 'cadastrar_usuario.php';
        modal.style.display = 'block';
    }
    //------------------------------------------//

    //Funções para o modal de edição de usuários
    function openModalEdit(userId) {
        var modal = document.querySelector('.modal');
        var iframe = document.querySelector('iframe');
        iframe.src = 'editar_usuario.php?id=' + userId;
        modal.style.display = 'block';
    }
    //------------------------------------------//    

    //Código para excluir o usuário
    var excluirButtons = document.querySelectorAll('.excluir-btnUser');
    excluirButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var userId = this.getAttribute('data-id');
            var confirmDelete = confirm('Tem certeza de que deseja excluir este usuário?');
            
            if (confirmDelete) {
                var userId = this.getAttribute('data-id'); 
                // Faz uma solicitação para o arquivo PHP de exclusão
                fetch('excluir_usuario.php?id=' + userId, {
                    method: 'GET'
                })
                .then(response => response.text())
                .then(data => {
                    // Exibe a resposta do servidor após a exclusão
                    alert(data);
                    
                    // Recarregar a página
                    location.reload();
                })
                .catch(error => {
                    console.error('Erro ao excluir o usuário:', error);
                });
            }
        });
    });
//--------------------------------------------//

//Funções para a tela de pacientes//
    //Funções para o modal de cadastrar paciente
    function openModalRegPac() {
        var modal = document.querySelector('.modal');
        var iframe = document.querySelector('iframe');
        iframe.src = 'cadastrar_paciente.php';
        modal.style.display = 'block';
    }
    //------------------------------------------//

    //Funções para o modal de edição de paciente
    function openModalEditPac(userId) {
        var modal = document.querySelector('.modal');
        var iframe = document.querySelector('iframe');
        iframe.src = 'editar_paciente.php?id=' + userId;
        modal.style.display = 'block';
    }
    //------------------------------------------//   
    //Código para excluir o paciente
    var excluirButtons = document.querySelectorAll('.excluir-btnPac');
    excluirButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var userId = this.getAttribute('data-id');
            var confirmDelete = confirm('Tem certeza de que deseja excluir este paciente?');
            
            if (confirmDelete) {
                var userId = this.getAttribute('data-id'); 
                // Faz uma solicitação para o arquivo PHP de exclusão
                fetch('excluir_paciente.php?id=' + userId, {
                    method: 'GET'
                })
                .then(response => response.text())
                .then(data => {
                    // Exibe a resposta do servidor após a exclusão
                    alert(data);
                    
                    // Recarregar a página
                    location.reload();
                })
                .catch(error => {
                    console.error('Erro ao excluir o paciente:', error);
                });
            }
        });
    });
    //------------------------------------------//  
//--------------------------------------------//

//Funções para a tela de serviços//
    //Funções para o modal de cadastrar serviços
    function openModalRegServ() {
        var modal = document.querySelector('.modal');
        var iframe = document.querySelector('iframe');
        iframe.src = 'cadastrar_servico.php';
        modal.style.display = 'block';
    }
    //------------------------------------------//

    //Funções para o modal de edição de serviços
    function openModalEditServ(userId) {
        var modal = document.querySelector('.modal');
        var iframe = document.querySelector('iframe');
        iframe.src = 'editar_servico.php?id=' + userId;
        modal.style.display = 'block';
    }
    //------------------------------------------//   
    //Código para excluir o serviços
    var excluirButtons = document.querySelectorAll('.excluir-btnServ');
    excluirButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var userId = this.getAttribute('data-id');
            var confirmDelete = confirm('Tem certeza de que deseja excluir este serviço?');
            
            if (confirmDelete) {
                var userId = this.getAttribute('data-id'); 
                // Faz uma solicitação para o arquivo PHP de exclusão
                fetch('excluir_servico.php?id=' + userId, {
                    method: 'GET'
                })
                .then(response => response.text())
                .then(data => {
                    // Exibe a resposta do servidor após a exclusão
                    alert(data);
                    
                    // Recarregar a página
                    location.reload();
                })
                .catch(error => {
                    console.error('Erro ao excluir o serviço:', error);
                });
            }
        });
    });
    //------------------------------------------//  
//--------------------------------------------//
