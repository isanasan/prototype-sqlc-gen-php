<?php

namespace Isanasan\SqlcGenPhpPlayground\Authors;

class Querier
{
    public function __construct(
        private PDO $pdo
    )
    {
    }
}
