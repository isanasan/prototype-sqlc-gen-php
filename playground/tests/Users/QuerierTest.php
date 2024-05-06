<?php

namespace Users;

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

    public function testCreateUser()
    {
        $userParam = new CreateUserParam(
            "test create user",
            "test_create@example.com",
            30
        );
        $got = $this->querier->createUser($userParam);

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

    public function testUpdateUserAgesSuccess()
    {
        $userParam = new CreateUserParam(
            "test update user",
            "test_update@example.com",
            30
        );
        $user = $this->querier->createUser($userParam);

        // Update the user age
        $updateUserAges = new updateUserAges(35, $user->id);
        $success = $this->querier->updateUserAges($updateUserAges);

        $this->assertTrue($success);

        // Fetch the updated user and assert the age is update
        $updatedUser = $this->querier->getUser($user->id);
        $this->assertEquals(35, $updatedUser->age);
    }
}
