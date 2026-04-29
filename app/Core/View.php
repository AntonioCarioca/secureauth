<?php

namespace App\Core;

/**
 * Responsável pelo gerenciamento e exibição das visões (views) do sistema.
 * Esta classe localiza arquivos de template e injeta variáveis dinâmicas
 * para a geração da interface do usuário.
 * 
 * @package antonio/secureauth-php
 * @author XxZeroxX
 * @version 1.0.0
 */
class View
{	
	/**
     * Renderiza um arquivo de visualização e injeta dados opcionais.
     * O método aceita uma notação de "ponto" para subdiretórios (ex: 'user.profile')
     * e converte automaticamente para o caminho do arquivo correspondente.
     * 
     * @param string $view O nome da view ou caminho (ex: 'home' ou 'admin.dashboard').
     * @param array $data  Um array associativo de dados que serão transformados em variáveis.
     * @return void
     */
	public static function render(string $view, array $data = []): void
	{
		/**
         * Importa variáveis do array para a tabela de símbolos atual.
         * Se $data tiver ['nome' => 'João'], cria-se uma variável $nome disponível na view.
         */
		extract($data);

        /**
         * __DIR__ refere-se a 'app/Core'. 
         * dirname(__DIR__) sobe um nível para 'app'.
         */
        $baseDir = dirname(__DIR__);
        /**
         * Resolve o caminho do arquivo.
         * Substitui o ponto (.) por barra (/) para permitir organização em subpastas.
         */
		$viewPath = $baseDir . '/Views/' . str_replace('.', '/', $view) . '.php';

		// Verifica a existência do arquivo antes de tentar o carregamento
		if (!file_exists($viewPath)) {
			http_response_code(404);
			echo "View não encontrada: {$view}";
			return;
		}
		/**
         * Inclui o arquivo da view.
         * Devido ao extract() acima, o arquivo PHP terá acesso direto às chaves do array $data.
         */
		require $viewPath;
	}
}
