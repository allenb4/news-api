<?php

namespace App\Lib\News;

use App\Exceptions\NewsException;
use Illuminate\Support\Facades\Http;

class Client extends AbstractClient
{
    public function __construct(string $baseUrl, array $auth = [])
    {
        $this->baseUrl = $baseUrl;
        $this->auth = $auth;
    }

    public function request(string $urlPath)
    {
        $response = Http::asJson()
            ->{$this->method}($this->baseUrl . $urlPath, $this->getQuery());

        if ($response->failed()) {
            dd($response->json());
            throw new NewsException('Third party error.');
        }

        return $response->json();
    }
}
