<?php
namespace Connections\Drivers;

use PDO;

final class MariaDB {
    private PDO $pdo;

    public function __construct(string $host, int $port, string $user, string $passwd, string $dbname)
    {
        try {
            $this->pdo = new PDO(
                'mysql:host='.$host.';dbname='.$dbname.';port='.$port,
                $user,
                $passwd
            );

            $this->init();
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    private function init(): void
    {
        $dbn = $this->pdo;

        $dbn->exec("CREATE TABLE IF NOT EXISTS urls_data (
                id BIGINT UNSIGNED AUTO_INCREMENT,
                url TEXT NOT NULL,
                length INT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            );
        ");
    }

    public function dbn(): PDO
    {
        return $this->pdo;
    }
}