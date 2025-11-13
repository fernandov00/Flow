<?php
ob_start();
$page = 'notes';
$title = 'Editar Anotação';
include "../config.php";
include "templates/head.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$anotacao_id = $_GET['id'] ?? null;

if (!$anotacao_id) {
    header("Location: notes.php");
    exit;
}

// busca anotação
$sql = "SELECT * FROM notas WHERE codigo = $anotacao_id AND cod_user = $user_id";
$result = mysqli_query($conexao, $sql);
$anotacao = mysqli_fetch_assoc($result);

if (!$anotacao) {
    header("Location: notes.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo']);
    $anotacao_texto = mysqli_real_escape_string($conexao, $_POST['anotacao']);
    $data_modificacao = date('Y-m-d');
    
    $sql = "UPDATE notas SET titulo = '$titulo', anotacao = '$anotacao_texto', data_modificacao = '$data_modificacao' WHERE codigo = $anotacao_id AND cod_user = $user_id";
    
    if (mysqli_query($conexao, $sql)) {
        ob_end_clean();
        header("Location: notes.php");
        exit;
    } else {
        $error_message = "Erro ao atualizar anotação";
    }
}
?>

<main>
    <section class="main">
        <div class="container mb-5" style="margin-top: 85px;">
            <h2 class="text-center mb-5">Editar Anotação</h2>
            
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?= htmlspecialchars($anotacao['titulo']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="anotacao" class="form-label">Anotação</label>
                            <textarea class="form-control" id="anotacao" name="anotacao" rows="10" required><?= htmlspecialchars($anotacao['anotacao']) ?></textarea>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            <a href="notes.php" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include "templates/footer.php" ?>