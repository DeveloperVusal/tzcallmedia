<?php
namespace Services;

use Connections\Conn;
use Connections\Drivers\MariaDB;

class Select {

    private MariaDB $mariadb;
    
    function __construct()
    {
        $this->mariadb = Conn::driver('Connections\\Drivers\\MariaDB', 'database_mariadb', 3306, 'uroot', 'uroot', 'callmedia');
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
                GROUP BY UNIX_TIMESTAMP(`created_at`) DIV 60
                ORDER BY `created_at`";
        echo "MySQL:\n";

        foreach ($this->mariadb->dbn()->query($sql) as $row) {
            echo $row['row_counts'] . "\t";
            echo $row['group_minute'] . "\t";
            echo $row['avg_length'] . "\t";
            echo $row['first_record'] . "\t";
            echo $row['last_record'] . "\n";
        }
    }
}