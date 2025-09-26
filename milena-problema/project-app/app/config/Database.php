<?php
declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;

/**
 * Classe responsável por gerenciar a conexão com o banco de dados
 */
class Database {
    // Configurações do banco de dados
    private string $host = 'localhost';
    private string $db_name = 'login';
    private string $username = 'root';
    private string $password = '&tec77@info!';
    private ?PDO $conn = null;

    /**
     * Obtém a conexão com o banco de dados
     * 
     * @return PDO
     */
    public function getConnection(): PDO {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                    $this->username,
                    $this->password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_PERSISTENT => false,
                    ]
                );
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}
