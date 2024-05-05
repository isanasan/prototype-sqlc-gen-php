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

    public function testCreateUser()
    {
        $got = $this->querier->createUser([
            "id" => 1,
            "name" => "test create user",
            "email" => "test_create@example.com",
            "age" => 30
        ]);

        $this->assertEquals(
            new User(...[
                "id" => 1,
                "name" => "test create user",
                "email" => "test_create@example.com",
                "age" => 30
            ]),
            $got
        );
    }

    public function testGetUser()
    {
        $this->assertEquals(
            new User(...[
                "id" => 1,
                "name" => "test create user",
                "email" => "test_create@example.com",
                "age" => 30
            ]),
            $this->querier->getUser(1)
        );
    }

    public function testGetNoUser()
    {
        $this->assertNull($this->querier->getUser(2));
    }

    public static function tearDownAfterClass(): void
    {
        $dsn = 'mysql:host=127.0.0.1;dbname=test;charset=utf8mb4';
        $username = 'root';
        $password = null;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $username, $password, $options);

        $pdo->exec('TRUNCATE users');
    }
}
