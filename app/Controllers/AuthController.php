<?php

namespace App\Controllers;

use App\Models\User;

/**
 * Responsável por gerenciar o fluxo de autenticação do sistema,
 * incluindo registro de novos usuários, login e encerramento de sessão.
 */
class AuthController
{	
	/**
	 * Processa o registro de um novo usuário.
	 * 
	 * @return void
	 */
	public function register(): void
	{	
		// Coleta e limpa espaços em branco dos inputs dos dados vindos do formulário (POST)
		$name = trim($_POST['name'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';

		// Verifica se o nome está vazio, se o e-mail é válido e a senha tem min. 6 caracteres
		if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
			// Armazena mensagem de erro na sessão para exibir na View
			$_SESSION['error'] = 'Preencha os dados corretamente.';
			// Redireciona de volta para o formulário de registro
			header('Location: /register');
			exit;
		}

		// Chama o método estático do Model User para persistir os dados
		User::create($name, $email, $password);
		// Define mensagem de sucesso e envia o usuário para a tela de login
		$_SESSION['success'] = 'Conta criada com sucesso.';
		header('Location: /login');

	}
	/**
	 * Autentica um usuário existente.
	 * 
	 * @return void
	 */
	public function login(): void
	{
		// Recupera as credenciais enviadas
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';

		// Busca o usuário no banco de dados através do e-mail
		$user = User::findByEmail($email);

		// Verifica se o usuário existe E se a senha digitada corresponde ao hash no banco
		if (!$user || !password_verify($password, $user->password)) {
			$_SESSION['error'] = 'E-mail ou senha inválidos.';
			header('Location: /login');
			exit; 
		}

		// Login bem-sucedido: Armazena dados essenciais na Global $_SESSION
		// Armazenamos apenas dados essenciais para identificar o usuário nas páginas protegidas
		$_SESSION['user'] = [
			'id'    => $user->id,
			'name'  => $user->name,
			'email' => $user->email,
			'role'  => $user->role,
		];

		// Redireciona para a área restrita (Dashboard)
		header('Location: /dashboard');
	}

	/**
	 * [Finaliza a sessão do usuário ativo.
	 * 
	 * @return void
	 */
	public function logout(): void
	{
		// Destrói todos os dados da sessão atual
		session_destroy();
		// Redireciona para login
		header('Location: /login');
	}
}
