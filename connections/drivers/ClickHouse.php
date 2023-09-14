<?php
namespace Connections\Drivers;

use Exception;
use Services\Request;

final class ClickHouse {
    private Request $request;

    private string $host;
    private int $port;
    public string $dbname;

    public function __construct(string $host, int $port, string $dbname = 'default')
    {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;

        $this->request = new Request($this->dsn());
        
        $this->init();
    }

    private function init(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->dbname}.urls_data (
                    id UUID,
                    url String NOT NULL,
                    length Int32,
                    created_at DateTime('Europe/Moscow') DEFAULT now(),
                    PRIMARY KEY(id)
                )  ENGINE = MergeTree();";
        $response = $this->request->request('POST', $sql, ['Content-type: text/plain']);

        if ($response['info']['http_code'] !== 200) {
            throw new Exception($response['body']);
        }
    }

    public function query(string $sql): array
    {
        $response = $this->request->request('POST', $sql, ['Content-type: text/plain']);

        if ($response['info']['http_code'] !== 200) {
            throw new Exception($response['body']);
        }

        return $response;
    }

    public function dsn(): string
    {
        return 'http://'.$this->host.':'.$this->port;
    }
}