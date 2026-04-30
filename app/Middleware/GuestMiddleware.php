<?php

namespace App\Middleware;

/**
 * Middleware para Visitantes (Guests).
 * 
 * Garante que apenas usuários não autenticados acessem determinadas rotas.
 * Se um usuário já autenticado tentar acessar essas rotas, ele será 
 * redirecionado para a área principal (dashboard).
 * 
 * @package App\Middleware
 * @author XxZeroxX
 * @version 1.0.0
 */
class GuestMiddleware
{
	/**
     * Redireciona usuários logados para longe de páginas restritas a visitantes.
     * 
     * Verifica a existência da sessão 'user'. Caso encontrada, assume-se que 
     * o usuário já está autenticado e não deve ver telas de login/registro.
     * 
     * @return void
     */
	public static function handle(): void
	{
		/**
         * Se a sessão do usuário estiver ativa, ele não deve estar aqui.
         */
		if (isset($_SESSION['user'])) {
			// Redireciona para a página inicial logada
			header('Location: /dashboard');

			/**
             * Interrompe a execução para garantir que o conteúdo da página 
             * de login/cadastro não seja enviado ao navegador.
             */
            exit;
		}
	} 
}
