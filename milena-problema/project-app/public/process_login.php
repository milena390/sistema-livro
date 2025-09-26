<?php
session_start();

require_once __DIR__ . '/../app/Models/UsuarioDAO.php';
require_once __DIR__ . '/../app/utils/Sanitizacao.php';


// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitiza as entradas
    $email = Sanitizacao::sanitizar($_POST['email'] ?? '');
    $senha = Sanitizacao::sanitizar($_POST['senha'] ?? '');

    // Verifica se campos estão preenchidos
    if (empty($email) || empty($senha)) {
        $_SESSION['erro_login'] = "Por favor, preencha todos os campos.";
        header("Location: ../public/login.php");
        exit;
    }

    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->validarLogin($email, $senha);

    if ($usuario) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario_id'] = $usuario->getId();
        $_SESSION['nome_usuario'] = $usuario->getNome();

        // Redireciona para a página do cadastro de livros
        header("Location: ../public/IndexL.php");
        exit;
    } else {
        $_SESSION['erro_login'] = "Email ou senha inválidos.";
        header("Location: ../public/login.php");
        exit;
    }
} else {
    // Se o acesso não for POST, redireciona para login
    header("Location: ../public/login.php");
    exit;
}
?>
