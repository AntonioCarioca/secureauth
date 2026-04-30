<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\View;
use App\Middleware\AuthMiddleware;

/**
 * Gerencia as operações da área restrita do painel de controle (Dashboard).
 * 
 * Esta classe orquestra o fluxo de dados entre o modelo de usuário e as 
 * telas de gerenciamento, garantindo que apenas usuários autorizados acessem.
 * 
 * @package App\Controllers
 * @author XxZeroxX
 * @version 1.0.0
 */
class DashboardController
{
    /**
     * Exibe a página principal do Dashboard.
     * 
     * O método primeiro invoca o middleware de autenticação para proteger a rota.
     * Se o usuário estiver logado, renderiza a view correspondente passando
     * os dados do usuário contidos na sessão.
     * 
     * @return void
     */
    public function index(): void
    {
        /**
         * Camada de Proteção:
         * Interrompe a execução e redireciona caso o usuário não esteja logado.
         */
        AuthMiddleware::handle();

        /**
         * Renderização da Interface:
         * @param string 'dashboard.index' Localizada em app/Views/dashboard/index.php
         * @param array ['user' => ...] Dados disponibilizados para a View.
         */
        View::render('dashboard.index', [
            'user' => $_SESSION['user']
        ]);
    }
}
