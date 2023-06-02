<?php

namespace App\Lib\News;

abstract class AbstractClient
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $auth;

    /**
     * @var array
     */
    protected $query;

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function setQuery(array $query = []): self
    {
        $this->query = $query;

        return $this;
    }

    public function getQuery():  array
    {
        return array_merge($this->query, $this->auth);
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    abstract public function request(string $urlPath);
}
