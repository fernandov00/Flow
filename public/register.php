<?php


$title = "Registro";
$page = 'register';

include "../config.php";
include "templates/head.php";
include "templates/navbar_simplificada.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $primeiro_nome = $_POST['primeiro_nome'];
    $nome_meio = $_POST['nome_meio'];
    $ultimo_nome = $_POST['ultimo_nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; 
    $data_nascimento = $_POST['data_nascimento'];
    
    
    $sql = "INSERT INTO usuario (primeiro_nome, nome_meio, ultimo_nome, email, senha, data_nascimento) 
            VALUES ('$primeiro_nome', '$nome_meio', '$ultimo_nome', '$email', '$senha', '$data_nascimento')";
    
    $resultado = mysqli_query($conexao, $sql);
    
    if ($resultado) {
        $_SESSION['user_id'] = mysqli_insert_id($conexao);
        $_SESSION['user_name'] = $primeiro_nome;
        header("Location: index.php");
        exit;
    } else {
        $error = "Erro ao criar conta: " . mysqli_error($conexao);
    }
}
?>

<main>
    <div class="container mb-5" style="margin-top: 85px;">
        <div class="my-5">
            <h1>Faça seu registro aqui</h1>
            <p>Já possui conta?</p>
            <a href="login.php" class="btn btn-outline-primary">Fazer login</a>
        </div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" class="row g-3" id="registerForm">
            <div class="col-12">
                <label for="primeiro_nome" class="form-label">Primeiro nome</label>
                <input type="text" class="form-control" id="primeiro_nome" name="primeiro_nome" required>
            </div>
            <div class="col-md-6">
                <label for="nome_meio" class="form-label">Nome do meio</label>
                <input type="text" class="form-control" id="nome_meio" name="nome_meio">
            </div>
            <div class="col-md-6">
                <label for="ultimo_nome" class="form-label">Sobrenome</label>
                <input type="text" class="form-control" id="ultimo_nome" name="ultimo_nome" required>
            </div>

            <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-md-6">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="col-md-6">
                <label for="confirmar_senha" class="form-label">Confirme a senha</label>
                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>

                <!-- esta div sera ativada quando o input possuir is-invalid -->
                <div class="invalid-feedback" id="passwordError">
                    As senhas não coincidem.
                </div>
            </div>
            <div class="col-md-6">
                <label for="data_nascimento" class="form-label">Data de nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary" id="submitBtn">Registrar</button>
            </div>
        </form>
    </div>
</main>

<script>
//TODO: revisado

document.addEventListener('DOMContentLoaded', function() {
    const senhaInput = document.getElementById('senha');
    const confirmarSenhaInput = document.getElementById('confirmar_senha');
    const submitBtn = document.getElementById('submitBtn');
    const registerForm = document.getElementById('registerForm');
    
//funcao utilizada para avisar em tempo real que as senhas não batem
    function verificarSenhas() { 
        const senha = senhaInput.value;
        const confirmarSenha = confirmarSenhaInput.value;
        
        if (senha !== confirmarSenha && confirmarSenha !== '') {
            confirmarSenhaInput.classList.add('is-invalid');
            submitBtn.disabled = true;
            return false;
        } else {
            confirmarSenhaInput.classList.remove('is-invalid');
            submitBtn.disabled = false;
            return true;
        }
    }
    
    // verifica quando o usuario digitar em qualquer um dos campos de senha
    senhaInput.addEventListener('input', verificarSenhas);
    confirmarSenhaInput.addEventListener('input', verificarSenhas);
    
    // verifica tambem quando o formulário for enviado
    registerForm.addEventListener('submit', function(e) {
        if (!verificarSenhas()) {
            e.preventDefault();
            confirmarSenhaInput.focus();
        }
    });
    
    verificarSenhas();
});
</script>

<?php include "templates/footer.php" ?>