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