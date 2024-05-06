<?php

namespace Isanasan\SqlcGenPhpPlayground\Users;

class User
{
    public function __construct(
        readonly int    $id,
        readonly string $name,
        readonly string $email,
        readonly int    $age,
    )
    {
    }
}