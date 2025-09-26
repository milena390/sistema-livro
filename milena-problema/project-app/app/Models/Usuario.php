<?php
declare(strict_types=1);

namespace App\Models;

class Usuario
{
    private ?int $id = null;
    private ?string $nome = null;
    private ?string $email = null;
    private ?string $senha_hash = null;
    private ?string $created_at = null;

    public function __construct(array $dados = [])
    {
        if (isset($dados['id'])) {
            $this->id = (int)$dados['id'];
        }
        if (isset($dados['nome'])) {
            $this->nome = $dados['nome'];
        }
        if (isset($dados['email'])) {
            $this->email = $dados['email'];
        }
        if (isset($dados['senha_hash'])) {
            $this->senha_hash = $dados['senha_hash'];
        }
        if (isset($dados['created_at'])) {
            $this->created_at = $dados['created_at'];
        }
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getSenhaHash(): ?string
    {
        return $this->senha_hash;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    // Setters
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setSenhaHash(string $senha_hash): void
    {
        $this->senha_hash = $senha_hash;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    // Helper para definir senha e já criar o hash
    public function setSenha(string $senha): void
    {
        $this->senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    }

    // Verifica se a senha fornecida bate com o hash armazenado
    public function verificarSenha(string $senha): bool
    {
        return password_verify($senha, $this->senha_hash ?? '');
    }
}
