<?php

namespace App\Models;

use App\Database;
use PDO;

/**
 * Modelo de Usuário.
 * 
 * Responsável por toda a persistência de dados e regras de negócio relacionadas
 * à entidade de usuários no banco de dados.
 * 
 * @package App\Models
 * @author XxZeroxX
 * @version 2.0.0
 */
class User
{	
    /**
     * Cria um novo registro de usuário no banco de dados.
     * 
     * Este método realiza o hash seguro da senha antes da inserção utilizando
     * o algoritmo padrão do PHP (BCRYPT por padrão).
     * 
     * @param string $name Nome completo do usuário.
     * @param string $email Endereço de e-mail único.
     * @param string $password Senha em texto puro (será criptografada).
     * @return bool True em caso de sucesso na criação, false caso contrário.
     */
    public static function create(string $name, string $email, string $password): bool
    {
        $pdo = Database::connect();
        
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        
        return $stmt->execute([
            'name'     => $name, 
            'email'    => $email, 
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    /**
     * Localiza um usuário pelo endereço de e-mail.
     * 
     * Útil para processos de autenticação e verificação de duplicidade de registros.
     * 
     * @param string $email O e-mail a ser pesquisado.
     * @return object|null Retorna um objeto contendo os dados do usuário ou null se não encontrado.
     */
    public static function findByEmail(string $email): ?object
    {
        $pdo = Database::connect();
        
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        
        // Retorna o resultado como objeto ou null se o fetch falhar
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    /**
     * Localiza um usuário pelo seu identificador único (ID).
     * 
     * @param int $id ID do usuário no banco de dados.
     * @return object|null Retorna as informações do usuário como objeto ou null.
     */
    public static function findById(int $id): ?object
    {
        $pdo = Database::connect();
        
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }
}
