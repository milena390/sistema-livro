<?php
declare(strict_types=1);

namespace App\Models;

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/../config/Database.php';

use App\Config\Database;
use PDO;

class UsuarioDAO
{
    private PDO $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Busca um usuário pelo email e retorna um objeto Usuario ou null
    public function buscarPorEmail(string $email): ?Usuario
    {
        $query = "SELECT * FROM usuario WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($resultado) {
                return new Usuario($resultado);
            }
        }

        return null;
    }

    // Valida login verificando email e senha, retorna objeto Usuario ou null
    public function validarLogin(string $email, string $senha): ?Usuario
    {
        $usuario = $this->buscarPorEmail($email);

        if ($usuario && $usuario->verificarSenha($senha)) {
            return $usuario;
        }

        return null;
    }

    // Cria novo usuário no banco, retorna true se sucesso
    public function criarUsuario(string $nome, string $email, string $senha): bool
    {
        // Verifica se email já existe para evitar duplicidade
        if ($this->buscarPorEmail($email) !== null) {
            return false; // usuário já existe
        }

        $query = "INSERT INTO usuario (nome, email, senha_hash) VALUES (:nome, :email, :senha)";
        $stmt = $this->conn->prepare($query);

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
