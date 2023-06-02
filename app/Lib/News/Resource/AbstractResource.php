<?php

namespace App\Lib\News\Resource;

use Illuminate\Http\Request;
use App\Lib\News\AbstractClient;

abstract class AbstractResource
{
    public $data;

    protected $basePath;

    protected $client;

    public function __construct(AbstractClient $client)
    {
        $this->client = $client;
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function list($query = []): self
    {
        $this->data = $this->client
            ->setMethod(Request::METHOD_GET)
            ->setQuery($query)
            ->request($this->getBasePath());

        return $this;
    }
}
