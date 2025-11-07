<?php 

$title = "Login";
$page = 'login';

include "../config.php";
include "templates/head.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha']; 
    

    $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
    $resultado = mysqli_query($conexao, $sql);
    
    if (mysqli_num_rows($resultado) > 0) {
        $user = mysqli_fetch_assoc($resultado);
        $_SESSION['user_id'] = $user['codigo'];
        $_SESSION['user_name'] = $user['primeiro_nome'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Email ou senha incorretos!";
    }
}
?>

<main>
    <div class="container" style="height: 100vh;">
        <div class="row align-items-center justify-content-center" style="height: 100%;">
            <div class="col-12 col-md-6 col-lg-4">
                <h2>Faça seu login</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="my-5">
                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
                </div>
                <div class="my-5">
                    <p>Não possui uma conta?</p>
                    <a href="register.php" class="btn btn-outline-primary">Criar conta</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include "templates/footer.php" ?>