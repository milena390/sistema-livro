<?php 
$title = 'Home - Sistema de Usuários'; 
$page = 'home';
$basePath = '/sistema-livro/milena-problema/project-app/public';
?>
<div class="container">
        <!-- Logotipo -->
        <img src="img/livro.jpg" alt="Logo da Biblioteca PJ" class="logo">

        <h1>Bem-vindo à biblioteca PM!</h1>
        <p>Faça seu login ou cadastro para explorar nosso mundo literário</p>

        <div class="buttons">
            <form action="login.php" method="get" style="display: inline;">
                <button type="submit">Login</button>
            </form>
            <form action="cadastrar.php" method="get" style="display: inline;">
                <button type="submit">Cadastro</button>
            </form>
        </div>
    </div>