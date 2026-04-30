<?php

use App\Core\Env;
use App\Core\Router;

/**
 * Arquivo de Entrada Principal (Front Controller).
 * 
 * Este script é o ponto central de todas as requisições da aplicação.
 * Ele inicializa o autoloading, gerencia a sessão, carrega as configurações
 * de ambiente e despacha a requisição para o roteador.
 */

// Importa o carregador automático de classes do Composer
require __DIR__ . '/../vendor/autoload.php';

// Carrega a definição das rotas da aplicação
$routes = require __DIR__ . '/../routes/web.php';

/**
 * Inicialização da Sessão.
 * Garante que a sessão esteja ativa apenas se ainda não tiver sido iniciada,
 * evitando erros de cabeçalho ou conflitos de estado.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carrega as variáveis de ambiente do arquivo .env para a superglobal $_ENV
Env::load(__DIR__ . '/../.env');

/**
 * Inicializa o componente de roteamento.
 * @var Router $router
 */
$router = new Router($routes);

/**
 * Executa o despacho da rota.
 * Com base no método HTTP (GET, POST, etc.) e na URI solicitada,
 * o roteador decidirá qual Controller deve ser acionado.
 */
$router->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);
