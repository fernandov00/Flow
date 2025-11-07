<?php
include "../config.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT codigo, titulo, data_entrega as start, descricao 
        FROM tarefas 
        WHERE cod_user = $user_id 
        AND data_entrega IS NOT NULL 
        AND concluida = 0";
        
$resultado = mysqli_query($conexao, $sql);

$events = [];
if ($resultado) {
    while ($task = mysqli_fetch_assoc($resultado)) {
        $events[] = [
            'id' => $task['codigo'],
            'title' => $task['titulo'],
            'start' => $task['start'],
            'description' => $task['descricao']
        ];
    }
}

echo json_encode($events);
?>