<?php
namespace Services;

use Connections\Conn;
use Connections\Drivers\ClickHouse;
use Connections\Drivers\MariaDB;

class Queue {

    private MariaDB $mariadb;
    private ClickHouse $clhouse;
    
    function __construct()
    {
        $this->mariadb = Conn::driver('Connections\\Drivers\\MariaDB', getenv('MARIADB_HOST'), getenv('MARIADB_PORT'), getenv('MARIADB_USER'), getenv('MARIADB_PASSWORD'), getenv('MARIADB_DATABASE'));
        $this->clhouse = Conn::driver('Connections\\Drivers\\ClickHouse', getenv('CLICKHOUSE_HOST'), getenv('CLICKHOUSE_PORT'), getenv('CLICKHOUSE_DATABASE'));
    }

    public function setDb(string $url): void
    {
        $curl = new Url($url);
        $_url = $curl->request->info()['url'];
        $_contLength = $curl->getContentLength();

        // mysql
        $sth = $this->mariadb->dbn()->prepare("INSERT INTO urls_data (url, length) VALUES(?, ?)");
        $isset = $sth->execute([$_url, $_contLength]);

        echo ($isset)?"  [+] Set is successfully in MySQL \n":"  [x] Set is not successfully in MySQL\n";

        // clickhouse
        $res = $this->clhouse->query("INSERT INTO {$this->clhouse->dbname}.urls_data (id, url, length) VALUES(generateUUIDv4(), '{$_url}', '{$_contLength}')");

        $isset2 = ($res['info']['http_code'] === 200)?true:false;

        echo ($isset2)?"  [+] Set is successfully in ClickHouse \n":"  [x] Set is not successfully in ClickHouse\n";
    }
}