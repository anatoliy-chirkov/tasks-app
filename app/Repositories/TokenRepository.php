<?php

namespace Repositories;

use Core\Db\DbContext;

class TokenRepository
{
    private $context;

    public function __construct(DbContext $context)
    {
        $this->context = $context;
    }

    public function save(string $token)
    {
        $sql = "INSERT INTO token VALUES (null, ?)";

        $this->context->query($sql, [$token]);
    }

    public function find(string $token)
    {
        $sql = "SELECT id FROM token WHERE token = ?";

        return $this->context->query($sql, [$token]);
    }

    public function removeAllTokens()
    {
        $sql = "TRUNCATE TABLE token";

        $this->context->query($sql);
    }
}
