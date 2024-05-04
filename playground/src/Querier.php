<?php

namespace Isanasan\SqlcGenPhpPlayground;

use PDO;

class Querier
{
    const getUser = '-- name: getUser :one
        SELECT id, name, email, age FROM users
        WHERE id = ?
    ';

    public function __construct(
        private PDO $pdo
    )
    {
    }

    public function getUser(int $id) {
        $stmt = $this->pdo->prepare(self::getUser);

        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}