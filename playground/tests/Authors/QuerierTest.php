<?php

namespace Authors;

use Isanasan\SqlcGenPhpPlayground\Users\CreateUserParam;
use Isanasan\SqlcGenPhpPlayground\Users\Querier;
use Isanasan\SqlcGenPhpPlayground\Users\updateUserAges;
use Isanasan\SqlcGenPhpPlayground\Users\User;
use PDO;
use PHPUnit\Framework\TestCase;

class QuerierTest extends TestCase
{
    private Querier $querier;

    public function setUp(): void
    {
        parent::setUp();

        $dsn = 'mysql:host=127.0.0.1;dbname=test;charset=utf8mb4';
        $username = 'root';
        $password = null;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $username, $password, $options);

        $this->querier = new Querier($pdo);
    }

    public function testBooksByTags()
    {
        
    }
}
