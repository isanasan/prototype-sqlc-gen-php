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

    public function createUser(CreateUserParam $arg): ?User
    {
        $stmt = $this->pdo->prepare(self::createUser);

        $stmt->bindValue(1, $arg->name, PDO::PARAM_STR);
        $stmt->bindValue(2, $arg->email, PDO::PARAM_STR);
        $stmt->bindValue(3, $arg->age, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $lastInsertId = $this->pdo->lastInsertId();
            return $this->getUser($lastInsertId); // fetch user with new id
        }
        return null; // null if insert operation fails
    }

    const updateUserAges = '-- name: UpdateUserAges :exec
        UPDATE users
            SET age = ?
        WHERE
            id = ?
        ';

    public function updateUserAges(updateUserAges $arg): bool
    {
        $stmt = $this->pdo->prepare(self::updateUserAges);

        $stmt->bindValue(1, $arg->age, PDO::PARAM_INT);
        $stmt->bindValue(2, $arg->id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

readonly class CreateUserParam
{
    function __construct(
        public string $name,
        public string $email,
        public int    $age,
    )
    {
    }
}

readonly class updateUserAges
{
    function __construct(
        public int $age,
        public int $id,
    )
    {
    }
}