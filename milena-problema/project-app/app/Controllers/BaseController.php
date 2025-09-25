<?php
/**
 * Controlador Base
 * Fornece funcionalidades comuns para todos os controladores
 */

declare(strict_types=1);

namespace App\Controllers;

class BaseController 
{
    /**
     * Renderiza uma view
     * @param string $view Nome da view
     * @param array $data Dados para passar para a view
     * @return void
     */
    protected function render(string $view, array $data = []): void 
    {
        // Extrair dados para variáveis
        extract($data);
        
        // Caminho da view
        $viewPath = __DIR__ . '/../Views/pages/' . $view . '.php';
        $layoutPath = __DIR__ . '/../Views/layouts/main.php';
        
        // Verificar se a view existe
        if (file_exists($viewPath)) {
            // Iniciar buffer de saída
            ob_start();
            include $viewPath;
            $content = ob_get_clean();
            
            // Incluir o layout principal
            include $layoutPath;
        } else {
            die("View não encontrada: " . $viewPath);
        }
    }
    
    /**
     * Redireciona para uma URL
     * @param string $url URL de destino
     * @return void
     */
    protected function redirect(string $url): void 
    {
        header("Location: " . $url);
        exit();
    }
    
    /**
     * Método público para renderizar (para uso temporário)
     * @param string $view Nome da view
     * @param array $data Dados para passar para a view
     * @return void
     */
    public function renderView(string $view, array $data = []): void 
    {
        $this->render($view, $data);
    }
}
?>