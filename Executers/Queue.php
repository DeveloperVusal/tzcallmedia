<?php
namespace Executers;

use Connections\Conn;
use Connections\Drivers\MariaDB;

class Queue {

    private MariaDB $mariadb;
    
    function __construct()
    {
        $this->mariadb = Conn::driver('\\Connections\\Drivers\\MariaDB', 'localhost', 3306, 'root', 'root', 'callmedia');
    }

    public function setDb(string $url): void
    {
        $curl = new Url($url);

        $sth = $this->mariadb->dbn()->prepare("INSERT INTO urls_data (url, length) VALUES(?, ?)");
        $isset = $sth->execute([$curl->info()['url'], $curl->getContentLength()]);

        echo ($isset)?"  [+] Set is successfully \n":"  [x] Set is not successfully \n";
    }
}