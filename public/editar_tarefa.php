<?php
ob_start();
$page = 'tasks';
$title = 'Editar Tarefa';
include "../config.php";
include "templates/head.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$tarefa_id = $_GET['id'] ?? null;

if (!$tarefa_id) {
    header("Location: tasks.php");
    exit;
}

$sql = "SELECT * FROM tarefas WHERE codigo = $tarefa_id AND cod_user = $user_id";
$result = mysqli_query($conexao, $sql);
$tarefa = mysqli_fetch_assoc($result);

if (!$tarefa) {
    header("Location: tasks.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $urgencia = (int)$_POST['urgencia'];
    $data_entrega = mysqli_real_escape_string($conexao, $_POST['data_entrega']);
    $hora_entrega = mysqli_real_escape_string($conexao, $_POST['hora_entrega']);
    
    // Validação simples
    $hoje = date('Y-m-d');
    if ($data_entrega && $data_entrega < $hoje) {
        $error_message = "Erro: A data de entrega não pode ser anterior à data atual.";
    } else {
        $sql = "UPDATE tarefas SET titulo = '$titulo', descricao = '$descricao', urgencia = $urgencia, data_entrega = '$data_entrega', hora_entrega = '$hora_entrega' 
                WHERE codigo = $tarefa_id AND cod_user = $user_id";
        
        if (mysqli_query($conexao, $sql)) {
            ob_end_clean();
            header("Location: tasks.php");
            exit;
        } else {
            $error_message = "Erro ao atualizar tarefa";
        }
    }
}
?>

<main>
    <section class="main">
        <div class="container mb-5" style="margin-top: 85px;">
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $error_message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <h2 class="text-center mb-5">Editar Tarefa</h2>
            
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($tarefa['titulo']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="5" required><?= htmlspecialchars($tarefa['descricao']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="urgencia" class="form-label">Urgência</label>
                            <select class="form-select" id="urgencia" name="urgencia" required>
                                <option value="1" <?= $tarefa['urgencia'] == 1 ? 'selected' : '' ?>>Baixa</option>
                                <option value="2" <?= $tarefa['urgencia'] == 2 ? 'selected' : '' ?>>Média</option>
                                <option value="3" <?= $tarefa['urgencia'] == 3 ? 'selected' : '' ?>>Alta</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="data_entrega" class="form-label">Data de Entrega</label>
                                <input type="date" class="form-control" id="data_entrega" name="data_entrega" value="<?= $tarefa['data_entrega'] ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="hora_entrega" class="form-label">Hora de Entrega</label>
                                <input type="time" class="form-control" id="hora_entrega" name="hora_entrega" value="<?= $tarefa['hora_entrega'] ?>">
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            <a href="tasks.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const dataInput = document.getElementById('data_entrega');
    if (dataInput) {
        const today = new Date().toISOString().split('T')[0];
        dataInput.min = today;
    }
});
</script>

<?php include "templates/footer.php" ?>