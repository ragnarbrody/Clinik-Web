
// Captura o elemento de entrada de texto
var searchInput = document.getElementById('searchInput');

// Adiciona um ouvinte de evento de entrada de texto para a barra de pesquisa
searchInput.addEventListener('input', function () {
    var searchTerm = searchInput.value.toLowerCase(); // Obtém o valor digitado e converte para minúsculas

    // Seleciona todas as linhas da tabela, exceto a primeira (cabeçalho)
    var rows = document.querySelectorAll('table tr:not(:first-child)');

    // Loop através das linhas da tabela e verifica se o nome ou CPF corresponde ao termo de pesquisa
    rows.forEach(function (row) {
        var nome = row.cells[1].textContent.toLowerCase(); // Obtém o nome da célula
        var cpf = row.cells[2].textContent.toLowerCase(); // Obtém o CPF da célula

        // Verifica se o nome ou CPF contém o termo de pesquisa
        if (nome.includes(searchTerm) || cpf.includes(searchTerm)) {
            row.style.display = ''; // Se corresponder, mostra a linha
        } else {
            row.style.display = 'none'; // Se não corresponder, oculta a linha
        }
    });
});
