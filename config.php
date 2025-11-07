<?php
// arquivo para verificar se a sessão está ativa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// configurações do bd
$host = 'localhost';
$dbname = 'flow'; 
$username = 'root';
$password = '';


$conexao = mysqli_connect($host, $username, $password, $dbname);


if (!$conexao) {
    die("Erro de conexao");
}

?>