<?php

namespace Framework\Auth;

use App\Configuration;
use Framework\Core\App;
use Framework\Core\IIdentity;
use Framework\Core\IAuthenticator;
use Framework\DB\Connection;
use PDO;

/**
 * Authenticator that checks users table for credentials.
 */
class DbAuthenticator extends SessionAuthenticator
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    protected function authenticate(string $username, string $password): ?IIdentity
    {
        $sql = 'SELECT id, username, email, password FROM `users` WHERE username = :u OR email = :u LIMIT 1';
        $stmt = Connection::getInstance()->prepare($sql);
        $stmt->execute(['u' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && password_verify($password, $row['password'])) {
            return new DbUser((int)$row['id'], $row['username'], $row['email']);
        }
        return null;
    }
}

