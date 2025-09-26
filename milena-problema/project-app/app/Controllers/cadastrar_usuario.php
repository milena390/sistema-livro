<?php
// Inicia a sessão para poder armazenar mensagens
session_start();

// Inclui o arquivo UsuarioDAO.php, que está no diretório Models (relativo ao diretório Controllers)
require_once __DIR__ . '/../Models/UsuarioDAO.php';

// Inclui o arquivo Sanitizacao.php, que está no diretório utils (relativo ao diretório Controllers)
require_once __DIR__ . '/../utils/Sanitizacao.php';

// Sanitiza as entradas para evitar vulnerabilidades como XSS ou SQL Injection
$nome = Sanitizacao::sanitizar($_POST['nome']);
$email = Sanitizacao::sanitizar($_POST['email']);
$senha = Sanitizacao::sanitizar($_POST['senha']);

// Cria uma instância da classe UsuarioDAO
$usuarioDAO = new UsuarioDAO();

// Chama o método para criar o usuário, passando os dados sanitizados
$usuario = $usuarioDAO->criarUsuario($nome, $email, $senha);

// Verifica se o usuário foi criado com sucesso e define a mensagem correspondente na sessão
if ($usuario) {
    // Mensagem de sucesso
    $_SESSION['mensagem'] = "Usuário criado com sucesso! :)";
} else {
    // Mensagem de erro caso o nome ou email já existam
    $_SESSION['mensagem'] = "Erro ao criar usuário :(. Esse email ou nome pode já estar sendo utilizado.";
}

// Redireciona o usuário para a página de cadastro
header("Location: ../public/cadastrar.php");
exit();
?>
