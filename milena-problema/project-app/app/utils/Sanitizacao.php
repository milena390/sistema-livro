<?php
declare(strict_types=1);

class Sanitizacao
{
    public static function sanitizar(string $dado): string
    {
        // Remove espaços em branco do início e fim
        $dado = trim($dado);
        // Remove barras invertidas (slashes)
        $dado = stripslashes($dado);
        // Converte caracteres especiais em entidades HTML para evitar XSS
        $dado = htmlspecialchars($dado, ENT_QUOTES, 'UTF-8');
        return $dado;
    }
}
