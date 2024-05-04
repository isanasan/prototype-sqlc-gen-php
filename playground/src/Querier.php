<?php

namespace Isanasan\SqlcGenPhpPlayground;

use PDO;

class Querier
{
    public function __construct(
        private PDO $pdo
    )
    {
    }

    public function getUser(int $id) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');

        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}