<?php
session_start();

require_once __DIR__ . '/../Models/UsuarioDAO.php';
require_once __DIR__ . '/../utils/Sanitizacao.php';

// ✅ Usa o namespace correto
use App\Models\UsuarioDAO;

// Verifica se os dados foram enviados
if (!isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos!";
    header("Location: ../public/cadastrar.php");
    exit();
}

// Sanitiza entradas
$nome = Sanitizacao::sanitizar($_POST['nome']);
$email = Sanitizacao::sanitizar($_POST['email']);
$senha = Sanitizacao::sanitizar($_POST['senha']);

// Valida email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['mensagem'] = "Email inválido!";
    header("Location: ../public/cadastrar.php");
    exit();
}

// ✅ Agora o PHP sabe onde encontrar UsuarioDAO
$usuarioDAO = new UsuarioDAO();
$usuario = $usuarioDAO->criarUsuario($nome, $email, $senha);

// Define mensagem
if ($usuario) {
    $_SESSION['mensagem'] = "Usuário criado com sucesso! :)";
} else {
    $_SESSION['mensagem'] = "Erro ao criar usuário :(. Esse email ou nome pode já estar sendo utilizado.";
}

// Redireciona
header("Location: ../public/cadastrar.php");
exit();
?>
