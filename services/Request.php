<?php
namespace Services;

class Request {

    private string $url;
    private array $urlInfo = [];
    private string $urlBody;

    function __construct(string $url, string $method = 'GET', array $data = [])
    {
        $this->url = $url;

        $response = $this->request($method, $data);
        $this->urlBody = $response['body'];
        $this->urlInfo = $response['info'];
    }

    public function request(string $method = 'GET', mixed $data = null, array $headers = []): array
    {
        $ch = curl_init($this->url);

        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        if (sizeof($headers)) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $urlBody = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            throw new \Exception($error_msg);
        }

        $urlInfo = curl_getinfo($ch);

        curl_close($ch);

        return [
            'body' => $urlBody,
            'info' => $urlInfo,
        ];
    }

    public function info(): array
    {
        return $this->urlInfo;
    }

    public function body(): string
    {
        return $this->urlBody;
    }
}