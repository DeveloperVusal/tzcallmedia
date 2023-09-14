<?php
namespace Services;

class Request {

    private array $urlInfo = [];
    private string $urlBody;

    function __construct(string $url, string $method = 'GET', array $data = [])
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        if (!curl_errno($ch)) {
            $this->urlBody = curl_exec($ch);
            $this->urlInfo = curl_getinfo($ch);
        }

        curl_close($ch);
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