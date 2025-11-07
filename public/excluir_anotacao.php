<?php
include "../config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $anotacao_id = (int)$_POST['anotacao_id'];
    
    $sql = "DELETE FROM notas WHERE codigo = $anotacao_id AND cod_user = $user_id";
    
    if (mysqli_query($conexao, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
    exit;
}
?>
