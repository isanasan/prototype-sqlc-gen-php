<?php


use Isanasan\SqlcGenPhpPlayground\Querier;
use Isanasan\SqlcGenPhpPlayground\User;
use PHPUnit\Framework\TestCase;

class QuerierTest extends TestCase
{
    public function testGetUser()
    {
        $dsn = 'mysql:host=127.0.0.1;dbname=test;charset=utf8mb4';
        $username = 'root';
        $password = null;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $username, $password, $options);

        $querier = new Querier($pdo);

        $this->assertEquals(
            new User(...[
                "id" => 1,
                "name" => "hoge",
                "email" => "test@example.com",
                "age" => 20
            ]),
            $querier->getUser(1)
        );
    }

    public function testGetNoUser()
    {
        $dsn = 'mysql:host=127.0.0.1;dbname=test;charset=utf8mb4';
        $username = 'root';
        $password = null;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $pdo = new PDO($dsn, $username, $password, $options);

        $querier = new Querier($pdo);

        $this->assertNull($querier->getUser(2));
    }
}
