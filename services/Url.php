<?php
namespace Services;

class Url {

    public Request $request;
    private string $urlBody;
    
    function __construct(string $url)
    {
        $this->request = new Request($url);
        $this->urlBody = $this->request->body();
    }

    public function getContentLength(): int
    {
        return mb_strlen($this->urlBody);
    }
}