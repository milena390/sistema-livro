<?php
// Inicia a sessão para poder armazenar mensagens
session_start();

// Inclui o arquivo UsuarioDAO.php, que está no diretório Models (relativo ao diretório Controllers)
require_once __DIR__ . '/../app/Models/UsuarioDAO.php'; // Corrigido caminho

// Inclui o arquivo Sanitizacao.php, que está no diretório utils (relativo ao diretório Controllers)
require_once __DIR__ . '/../app/utils/Sanitizacao.php'; // Corrigido caminho

// Verifica se os dados foram enviados
if (!isset($_POST['nome'], $_POST['email'], $_POST['senha'])) {
    $_SESSION['mensagem'] = "Preencha todos os campos!";
    header("Location: ../public/cadastrar.php");
    exit();
}

// Sanitiza as entradas para evitar vulnerabilidades como XSS ou SQL Injection
$nome = Sanitizacao::sanitizar($_POST['nome']);
$email = Sanitizacao::sanitizar($_POST['email']);
$senha = Sanitizacao::sanitizar($_POST['senha']);

// Valida email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['mensagem'] = "Email inválido!";
    header("Location: ../public/cadastrar.php");
    exit();
}

// Cria uma instância da classe UsuarioDAO
$usuarioDAO = new UsuarioDAO();

// Chama o método para criar o usuário, passando os dados sanitizados
$usuario = $usuarioDAO->criarUsuario($nome, $email, $senha);

// Verifica se o usuário foi criado com sucesso e define a mensagem correspondente na sessão
if ($usuario) {
    $_SESSION['mensagem'] = "Usuário criado com sucesso! :)";
} else {
    $_SESSION['mensagem'] = "Erro ao criar usuário :(. Esse email ou nome pode já estar sendo utilizado.";
}

// Redireciona o usuário para a página de cadastro
header("Location: ../public/cadastrar.php");
exit();
?>
