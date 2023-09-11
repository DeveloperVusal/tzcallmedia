<?php
namespace Executers;

class Url {

    private array $urlInfo = [];
    private string $urlBody;

    function __construct(string $url)
    {
        // Запускаем запрос получаения сайта
        $ch = curl_init($url);

        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

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

    public function getContentLength(): int
    {
        return mb_strlen($this->urlBody);
    }
}