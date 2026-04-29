<?php

// inciar a sessão
session_start();

// faz a requisisão do arquivo de autoload
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;

// armazena a uri 
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// armazena o method do request
$method = $_SERVER['REQUEST_METHOD'];
// instancia um objeto da classe AuthController
$auth = new AuthController();

// caso a uri = / e o method = GET redireciona pra a home 
if ($uri === '/' && $method === 'GET') {
 	echo '<h1>SecureAuth PHP</h1><p><a href="/login">Login</a> | <a href="/register">Cadastrar</a></p>';
// caso a uri = /login e method = GET redireciona para o login
} elseif ($uri === '/login' && $method === 'GET') {
	echo '<form method="post"><input name="email" placeholder="E-mail"><input name="password" type="password" placeholder="Senha"><button>Entrar</button></form>';
// caso uri = /register e method = GET redireciona para register
} elseif ($uri === '/register' && $method === 'GET') {
	echo '<form method="post"><input name="name" placeholder="Nome"><input name="email" placeholder="E-mail"><input name="password" type="password" placeholder="Senha"><button>Cadastrar</button></form>';
// caso uri = login e method = POST efetua o login
} elseif ($uri === '/login' && $method === 'POST') {
	$auth->login();
// caso uri = /dashboard redireciona para a dashboard, !apenas tenha feito o login
} elseif ($uri === '/dashboard' && $method === 'GET') {
	echo isset($_SESSION['user']) ? '<h1>Dashboard</h1><p>Bem-vindo, '.$_SESSION['user']['name'].'</p><a href="/logout">Sair</a>' : header('Location: /login');
// caso uri = /logout efetua o logout e retona pra o login
} elseif ($uri === '/logout') {
	$auth->logout();
// caso uri = /registe e method = POST efetua o cadastro
} elseif ($uri === '/register' && $method === 'POST') {
	$auth->register();
// caso não encontre nenhuma rota
} else {
	http_response_code(404); echo 'Página não encontrada';
}
