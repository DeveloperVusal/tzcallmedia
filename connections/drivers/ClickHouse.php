<?php
namespace Connections\Drivers;

use PDO;

final class ClickHouse {
    private PDO $pdo;

    public function __construct(string $host, int $port, string $user, string $passwd, string $dbname)
    {
        try {
            $this->pdo = new PDO(
                'mysql:host='.$host.';dbname='.$dbname.';port='.$port,
                $user,
                $passwd
            );
            
            $this->init($dbname);

        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    private function init(string $dbname): void
    {
        $dbn = $this->pdo;

        // $dbn->exec("CREATE DATABASE ${$dbname};");

        $dbn->exec("CREATE TABLE IF NOT EXISTS ${$dbname}.urls_data (
                id UUID,
                url String NOT NULL,
                length Int32,
                created_at DateTime('Europe/Moscow') DEFAULT now(),
                PRIMARY KEY(id)
            );
        ");
    }

    public function dbn(): PDO
    {
        return $this->pdo;
    }
}