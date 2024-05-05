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

    public function getUser(int $id): ?User
    {
        $stmt = $this->pdo->prepare(self::getUser);

        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row !== false ? new User(...$row) : null;
    }

    const createUser = '-- name: CreateUser :execresult
        INSERT INTO users (
            name, email, age
        ) VALUES (
            ?, ?, ?
        )';

    public function createUser(array $data): ?User
    {
        $stmt = $this->pdo->prepare(self::createUser);

        $stmt->bindValue(1, $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(2, $data['email'], PDO::PARAM_STR);
        $stmt->bindValue(3, $data['age'], PDO::PARAM_INT);

        if($stmt->execute()) {
            $lastInsertId = $this->pdo->lastInsertId();
            return $this->getUser($lastInsertId); // fetch user with new id
        }
        return null; // null if insert operation fails
    }
}