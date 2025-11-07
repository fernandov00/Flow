<?php
include "../config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tarefa_id = (int)$_POST['tarefa_id'];
    $concluida = (int)$_POST['concluida'];
    
    if ($concluida) {
        $data_conclusao = date('Y-m-d H:i:s');
        $sql = "UPDATE tarefas SET concluida = 1, data_conclusao = '$data_conclusao' WHERE codigo = $tarefa_id AND cod_user = $user_id";
    } else {
        $sql = "UPDATE tarefas SET concluida = 0, data_conclusao = NULL WHERE codigo = $tarefa_id AND cod_user = $user_id";
    }
    
    if (mysqli_query($conexao, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
    exit;
}
?>