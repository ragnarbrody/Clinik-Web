<?php

$usuario = 'root';
$senha = 'imali8lu1';
$database = 'clinik';
$host = 'localhost';

$mysqli = new mysqli($host, $usuario, $senha, $database);

if($mysqli->error)
{
    die("Falha ao conectar ao banco de dados: " . $mysqli->error);
}

// Função para buscar Pacientes, Serviços e Profissionais com base no ID_clinica
function buscarDadosClinica($idClinica) {
    global $mysqli;
    $dados = array();

    // Buscar Pacientes
    $sqlPacientes = "SELECT ID, nome_completo, CPF, responsavel_legal, email FROM paciente WHERE ID_clinica = '$idClinica'";
    $resultPacientes = $mysqli->query($sqlPacientes);

    // Buscar Serviços
    $sqlServicos = "SELECT ID, Servico, Especialidade FROM servicos WHERE ID_clinica = '$idClinica'";
    $resultServicos = $mysqli->query($sqlServicos);

    // Buscar Profissionais
    $sqlProfissionais = "SELECT ID, Nome, Setor FROM usuarios WHERE ID_clinica = '$idClinica' AND Cargo = 'ESPECIALISTA'";
    $resultProfissionais = $mysqli->query($sqlProfissionais);  

    // Adicionar dados ao array
    $dados['pacientes'] = $resultPacientes->fetch_all(MYSQLI_ASSOC);
    $dados['servicos'] = $resultServicos->fetch_all(MYSQLI_ASSOC);
    $dados['profissionais'] = $resultProfissionais->fetch_all(MYSQLI_ASSOC);

    return $dados;
}

function contarAtendimentos($idUsuario) {
    global $mysqli;

    // Contar atendimentos para o usuário logado
    $sqlContarAtendimentos = "SELECT COUNT(*) AS total FROM atendimentos WHERE ID_profResponsavel = '$idUsuario' AND Situacao = 'Ativo'";
    $resultContarAtendimentos = $mysqli->query($sqlContarAtendimentos);
    $row = $resultContarAtendimentos->fetch_assoc();

    return $row['total'];
}