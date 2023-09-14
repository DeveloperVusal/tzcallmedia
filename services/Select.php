<?php
namespace Services;

use Connections\Conn;
use Connections\Drivers\ClickHouse;
use Connections\Drivers\MariaDB;

class Select {

    private MariaDB $mariadb;
    private ClickHouse $clhouse;
    
    function __construct()
    {
        $this->mariadb = Conn::driver('Connections\\Drivers\\MariaDB', getenv('MARIADB_HOST'), getenv('MARIADB_PORT'), getenv('MARIADB_USER'), getenv('MARIADB_PASSWORD'), getenv('MARIADB_DATABASE'));
        $this->clhouse = Conn::driver('Connections\\Drivers\\ClickHouse', getenv('CLICKHOUSE_HOST'), getenv('CLICKHOUSE_PORT'), getenv('CLICKHOUSE_DATABASE'));
    }

    public function getResult(): void
    {
        $sql = "SELECT
                    COUNT(`id`) AS row_counts,
                    MINUTE(`created_at`) AS group_minute,
                    AVG(`length`) AS avg_length,
                    MIN(`created_at`) AS first_record,
                    MAX(`created_at`) AS last_record
                FROM `urls_data`
                GROUP BY group_minute";
        echo "MySQL:\n";

        foreach ($this->mariadb->dbn()->query($sql) as $row) {
            echo $row['row_counts'] . "\t";
            echo $row['group_minute'] . "\t";
            echo $row['avg_length'] . "\t";
            echo $row['first_record'] . "\t";
            echo $row['last_record'] . "\n";
        }

        $sql2 = "SELECT
                    count(id) AS row_counts,
                    toMinute(toDateTime(created_at)) AS group_minute,
                    avg(length) AS avg_length,
                    min(created_at) AS first_record,
                    max(created_at) AS last_record
                FROM {$this->clhouse->dbname}.`urls_data`
                GROUP BY group_minute";

        $res = $this->clhouse->query($sql2);
        
        echo "ClickHouse:\n";
        
        if ($res['info']['http_code'] === 200) print_r($res['body']);
    }
}