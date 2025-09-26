<?php
/**
 * Controlador da Página Inicial
 */

declare(strict_types=1);

namespace App\Controllers;

// Se quiser, pode importar explicitamente
use App\Controllers\BaseController;

class HomeController extends BaseController 
{
    /**
     * Mostra a página inicial
     * @return void
     */
    public function index(): void 
    {
        $this->render('home');
    }
}
