<?php

namespace Framework\Auth;

use Framework\Core\IIdentity;

/**
 * Class DbUser
 * Lightweight identity wrapper for a database user row.
 */
class DbUser implements IIdentity
{
    public int $id;
    public string $username;
    public string $email;

    public function __construct(int $id, string $username, string $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->username;
    }
}

