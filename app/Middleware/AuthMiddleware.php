<?php

namespace App\Middleware;

/**
 * Middleware de Autenticação.
 * 
 * Esta classe é responsável por proteger rotas restritas, verificando se o
 * usuário possui uma sessão ativa antes de permitir o prosseguimento da requisição.
 * 
 * @package App\Middleware
 * @author XxZeroxX
 * @version 1.0.0
 */
class AuthMiddleware
{
	/**
     * Valida a sessão do usuário.
     * 
     * Se o índice 'user' não estiver presente na superglobal $_SESSION, 
     * o usuário é considerado não autenticado e é redirecionado para a 
     * página de login.
     * 
     * @return void
     */
	public static function handle(): void
	{
		/**
         * Verifica se a sessão do usuário existe.
         * Nota: Certifique-se de que session_start() foi chamado no início do ciclo de vida da app.
         */
		if (!isset($_SESSION['user'])) {
			// Interrompe o fluxo e redireciona para a área de autenticação
			header('Location: /login');

			/**
             * É uma boa prática encerrar a execução após um header de redirecionamento
             * para evitar que o restante do código da página seja processado.
             */
            exit;
		}
	}
}
