<?php

namespace App\Core;

/**
 * Sistema de Roteamento da Aplicação.
 * Esta classe é responsável por mapear URIs e métodos HTTP para seus respectivos
 * Controllers e métodos, suportando parâmetros dinâmicos via Expressões Regulares.
 * 
 * @package App\Core
 * @author XxZeroxX
 * @version 1.0.0
 */
class Router
{
	/**
	 * Cada rota deve ser um array: [método, uri, [Controller, método]].
	 * 
	 * @param array $routes Lista de rotas registradas.
	 */
	public function __construct(private array $routes = []) {}

	/**
     * Processa a requisição atual e despacha para o Controller adequado.
     * 
     * @param string $method O método HTTP da requisição (GET, POST, etc).
     * @param string $uri A URL solicitada pelo cliente.
     * @return mixed O retorno do método do Controller executado.
     */
	public function dispatch(string $method, string $uri): mixed
	{
		// Extrai apenas o caminho da URL (ignora query strings como ?id=1)
		$uri = parse_url($uri, PHP_URL_PATH);

		foreach ($this->routes as $route) {
			[$routeMethod, $routeUri, $handler] = $route;

			// Pula rotas que não correspondem ao método HTTP
			if ($method !== $routeMethod) {
				continue;
			}

			// Tenta casar a URI da rota com a URI atual
			$params = $this->matchRoute($routeUri, $uri);

			if ($params !== false) {
				return $this->execute($handler, $params);
			}
		}

		// Caso nenhuma rota seja encontrada
		http_response_code(404);
        echo "404 - Página não encontrada";
	}

	/**
     * Verifica se a URI atual corresponde ao padrão de uma rota registrada.
     * Converte marcações de parâmetros como {id} em expressões regulares.
     * 
     * @param string $routeUri O padrão definido na rota (ex: /user/{id}).
     * @param string $currentUri A URI real acessada pelo usuário.
     * @return array|false Retorna os parâmetros extraídos ou false se não houver match.
     */
	private function matchRoute(string $routeUri, string $currentUri): array|false
	{
		// Converte {slug} ou {id} em grupos de captura regex ([^/]+)
		$pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '([^/]+)', $routeUri);

		// Define os delimitadores e obriga o match do início ao fim da string
		$pattern = '#^' . $pattern . '$#';

		if (preg_match($pattern, $currentUri, $matches)) {
			// Remove o primeiro elemento (que é a string completa do match)
			array_shift($matches);
			return $matches;
		}

		return false;
	}

	/**
     * Instancia o Controller e executa o método correspondente.
     * 
     * @param array $handler Array contendo [NomeDaClasse, NomeDoMetodo].
     * @param array $params Parâmetros extraídos da URL para serem passados ao método.
     * @return mixed
     */
	private function execute(array $handler, array $params = []): mixed
	{
		[$controller, $method] = $handler;

		// Cria a instância do Controller dinamicamente
		$instance = new $controller();

		/**
         * Executa o método do Controller passando os parâmetros da URL como argumentos.
         * Se a URL for /user/10, o método receberá 10 como primeiro argumento.
         */
		return call_user_func_array([$instance, $method], $params);
	}
}
