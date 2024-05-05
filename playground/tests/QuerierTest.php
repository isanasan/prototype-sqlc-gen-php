<?php

use Isanasan\SqlcGenPhpPlayground\Querier;
use Isanasan\SqlcGenPhpPlayground\User;
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

    public function testGetUser()
    {
        $this->assertEquals(
            new User(...[
                "id" => 1,
                "name" => "hoge",
                "email" => "test@example.com",
                "age" => 20
            ]),
            $this->querier->getUser(1)
        );
    }

    public function testGetNoUser()
    {
        $this->assertNull($this->querier->getUser(2));
    }
}
