<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\View;
use App\Middleware\GuestMiddleware;

/**
 * Controlador de Autenticação.
 * 
 * Gerencia o fluxo de identidade dos usuários, incluindo a exibição de formulários,
 * processamento de cadastros, validação de credenciais de login e logout.
 * 
 * @package App\Controllers
 * @author XxZeroxX
 * @version 2.0.0
 */
class AuthController
{	
    /**
     * Exibe a página inicial de autenticação.
     * @return void
     */
    public function index(): void
    {
        GuestMiddleware::handle();
        View::render('auth.index');
    }

    /**
     * Exibe o formulário de login.
     * @return void
     */
    public function showLogin(): void
    {
        GuestMiddleware::handle();
        View::render('auth.login');
    }

    /**
     * Exibe o formulário de registro de novo usuário.
     * @return void
     */
    public function showRegister(): void
    {
        GuestMiddleware::handle();
        View::render('auth.register');
    }

    /**
     * Processa a criação de uma nova conta de usuário.
     * 
     * Valida os campos obrigatórios, sanitiza o e-mail e verifica a complexidade
     * mínima da senha antes de persistir no banco de dados.
     * 
     * @return void
     */
    public function register(): void
    {	
        GuestMiddleware::handle();

        // Coleta e sanitiza os dados de entrada
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        /**
         * Validação de Regras de Negócio:
         * 1. Nome obrigatório.
         * 2. E-mail em formato válido.
         * 3. Senha com no mínimo 6 caracteres.
         */
        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
            $_SESSION['error'] = 'Preencha os dados corretamente. A senha deve ter no mínimo 6 caracteres.';
            header('Location: /register');
            exit;
        }

        // Tenta criar o usuário no banco de dados
        User::create($name, $email, $password);

        $_SESSION['success'] = 'Conta criada com sucesso. Faça seu login.';
        header('Location: /login');
        exit;
    }

    /**
     * Realiza a tentativa de autenticação do usuário.
     * 
     * Verifica se o e-mail existe no sistema e se a senha fornecida é
     * compatível com o hash armazenado no banco de dados.
     * 
     * @return void
     */
    public function login(): void
    {
        GuestMiddleware::handle();

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Busca o modelo do usuário pelo e-mail fornecido
        $user = User::findByEmail($email);

        /**
         * Verificação de Segurança:
         * O password_verify compara o texto puro com o hash Bcrypt.
         */
        if (!$user || !password_verify($password, $user->password)) {
            $_SESSION['error'] = 'E-mail ou senha inválidos.';
            header('Location: /login');
            exit; 
        }

        /**
         * Inicialização da Sessão do Usuário:
         * Armazena um array com os dados públicos para persistência entre requisições.
         */
        $_SESSION['user'] = [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role ?? 'user', // Define um papel padrão caso não exista
        ];

        header('Location: /dashboard');
        exit;
    }

    /**
     * Finaliza a sessão do usuário e limpa os dados.
     * 
     * @return void
     */
    public function logout(): void
    {
        // Remove todas as variáveis de sessão e destrói o arquivo no servidor
        session_unset();
        session_destroy();

        header('Location: /login');
        exit;
    }
}
