<?php
include "../config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tarefa_id = (int)$_POST['tarefa_id'];
    
    $sql = "DELETE FROM tarefas WHERE codigo = $tarefa_id AND cod_user = $user_id";
    
    if (mysqli_query($conexao, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
    exit;
}
?>