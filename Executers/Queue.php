<?php
namespace Executers;

use Connections\Conn;
use Connections\Drivers\ClickHouse;
use Connections\Drivers\MariaDB;

class Queue {

    private MariaDB $mariadb;
    private ClickHouse $clhouse;
    
    function __construct()
    {
        $this->mariadb = Conn::driver('Connections\\Drivers\\MariaDB', 'localhost', 3306, 'root', 'root', 'callmedia');
        // $this->clhouse = Conn::driver('Connections\\Drivers\\ClickHouse', 'localhost', 8123, 'default ', '', 'default');
    }

    public function setDb(string $url): void
    {
        $curl = new Url($url);

        // mysql
        $sth = $this->mariadb->dbn()->prepare("INSERT INTO urls_data (url, length) VALUES(?, ?)");
        $isset = $sth->execute([$curl->info()['url'], $curl->getContentLength()]);

        echo ($isset)?"  [+] Set is successfully in MySQL \n":"  [x] Set is not successfully in MySQL\n";

        // // clickhouse
        // $sth2 = $this->clhouse->dbn()->prepare("INSERT INTO urls_data (url, length) VALUES(?, ?)");
        // $isset2 = $sth2->execute([$curl->info()['url'], $curl->getContentLength()]);

        // echo ($isset2)?"  [+] Set is successfully in ClickHouse \n":"  [x] Set is not successfully in ClickHouse\n";
    }
}