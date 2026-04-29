<?php

namespace App\Controllers;

use App\Models\User;

/**
 * 
 */
class AuthController
{	
	/**
	 * [register description]
	 * @return [type] [description]
	 */
	public function register(): void
	{
		$name = trim($_POST['name'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';

		if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
			$_SESSION['error'] = 'Preencha os dados corretamente.';
			header('Location: /register');
			exit;
		}

		User::create($name, $email, $password);
		$_SESSION['success'] = 'Conta criada com sucesso.';
		header('Location: /login');

	}
	/**
	 * [login description]
	 * @return [type] [description]
	 */
	public function login(): void
	{
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';

		$user = User::findByEmail($email);

		if (!$user || !password_verify($password, $user->password)) {
			$_SESSION['error'] = 'E-mail ou senha inválidos.';
			header('Location: /login');
			exit; 
		}

		$_SESSION['user'] = [
			'id'    => $user->id,
			'name'  => $user->name,
			'email' => $user->email,
			'role'  => $user->role,
		];

		header('Location: /dashboard');
	}

	/**
	 * [logout description]
	 * @return [type] [description]
	 */
	public function logout(): void
	{
		session_destroy();
		header('Location: /login');
	}
}
