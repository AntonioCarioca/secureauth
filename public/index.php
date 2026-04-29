<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$auth = new AuthController();

if ($uri === '/' && $method === 'GET') {
 	echo '<h1>SecureAuth PHP</h1><p><a href="/login">Login</a> | <a href="/register">Cadastrar</a></p>';
} elseif ($uri === '/login' && $method === 'GET') {
	echo '<form method="post"><input name="email" placeholder="E-mail"><input name="password" type="password" placeholder="Senha"><button>Entrar</button></form>';
} elseif ($uri === '/register' && $method === 'GET') {
	echo '<form method="post"><input name="name" placeholder="Nome"><input name="email" placeholder="E-mail"><input name="password" type="password" placeholder="Senha"><button>Cadastrar</button></form>';
} elseif ($uri === '/login' && $method === 'POST') {
	$auth->login();
} elseif ($uri === '/dashboard' && $method === 'GET') {
	echo isset($_SESSION['user']) ? '<h1>Dashboard</h1><p>Bem-vindo, '.$_SESSION['user']['name'].'</p><a href="/logout">Sair</a>' : header('Location: /login');
} elseif ($uri === '/logout') {
	$auth->logout();
} elseif ($uri === '/register' && $method === 'POST') {
	$auth->register();
} else {
	http_response_code(404); echo 'Página não encontrada';
}
