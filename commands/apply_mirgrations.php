<?php

$config = [
    'host' => getenv('DB_HOST'),
    'port' => getenv('DB_PORT'),
    'name' => getenv('DB_NAME'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD')
];

$migrations = array_diff(scandir(__DIR__ . '../migrations'), ['.', '..']);


$dsn = "mysql:dbname={$config['name']};host={$config['host']}:{$config['port']}";
$dbh = new \PDO($dsn, $config['username'], $config['password']);

foreach ($migrations as $migration) {
    $sql = file_get_contents($migrations);

    $sth = $this->dbh->prepare($sql);
    $sth->execute();
}
