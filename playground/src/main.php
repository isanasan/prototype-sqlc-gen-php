<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Isanasan\SqlcGenPhpPlayground\Querier;

$dsn = 'mysql:host=127.0.0.1;dbname=test;charset=utf8mb4';
$username = 'root';
$password = null;
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $username, $password, $options);

$querier = new Querier($pdo);

$data = $querier->getUser(1);

var_dump($data);
