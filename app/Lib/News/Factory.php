<?php

namespace App\Lib\News;

use App\Lib\News\Resource\AbstractResource;
use App\Lib\News\Resource\{NewsApiResource,TheGuardianResource,NyTimesResource};

class Factory
{
    protected function build(
        string $resourceClass,
        string $baseUrl,
        array $credentials = []
    )
    {
        return new $resourceClass(new Client($baseUrl, $credentials));
    }

    public function newsApi(): AbstractResource
    {
        return $this->build(
            NewsApiResource::class,
            config('news.news_api.api_url'),
            ['apiKey' => config('news.news_api.api_key')]
        );
    }

    public function theGuardian(): AbstractResource
    {
        return $this->build(
            TheGuardianResource::class,
            config('news.the_guardian.api_url'),
            ['api-key' => config('news.the_guardian.api_key')]
        );
    }

    public function nyTimes(): AbstractResource
    {
        return $this->build(
            NyTimesResource::class,
            config('news.ny_times.api_url'),
            ['api-key' => config('news.ny_times.api_key')]
        );
    }
}
