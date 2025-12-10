<?php

namespace App\Models;

use Framework\Core\Model;

/**
 * Class User
 *
 * Model representing a user account.
 * Table expected: `users` with columns: id, username, email, password, created_at, updated_at
 */
class User extends Model
{
    // Optional: override table name and primary key if your DB uses different names
    protected static ?string $tableName = 'users';
    protected static ?string $primaryKey = 'id';

    // Model properties (non-static)
    public ?int $id = null;
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public ?string $created_at = null;
    public ?string $updated_at = null;

    /**
     * Convenience: set password (hashes the plain password)
     * @param string $plain
     * @return void
     */
    public function setPassword(string $plain): void
    {
        $this->password = password_hash($plain, PASSWORD_DEFAULT);
    }

    /**
     * Verify a plain password against stored hash
     * @param string $plain
     * @return bool
     */
    public function verifyPassword(string $plain): bool
    {
        if (empty($this->password)) {
            return false;
        }
        return password_verify($plain, $this->password);
    }
}

