<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\News\NewsFacade;
use App\Models\{Article,Category};
use Illuminate\Support\Carbon;

use function PHPSTORM_META\map;

class NewsAggregator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:news-aggregator
                                {--categoryId=: Category ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aggregate news and save it to our database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $categoryId = $this->option('categoryId');
        if (empty($categoryId)) {
            $this->error('Category ID is missing on the argument');
            return 0;
        }

        $category = Category::findOrFail($categoryId);

        $articles = array_merge(
            $this->syncNewsApi($category),
            $this->syncNyTimes($category),
            $this->syncTheGuardian($category)
        );

        Article::insert($articles);
    }

    protected function syncNyTimes(Category $category)
    {
        $response = NewsFacade::nyTimes()
            ->list([
                'q' => $category->name,
                'begin_date' => now()->subDay()->format('Ymd'),
                'end_date' => now()->format('Ymd')
            ]);

        return $this->transformNyTimesResponse(
            $category->id,
            $response->data['response']['docs']
        );
    }

    protected function syncNewsApi(Category $category)
    {
        $response = NewsFacade::newsApi()
            ->list([
                'category' => $category->name,
                'country' => 'us',
                'from' => now()->format('Y-m-d'),
                'sortBy' => 'publishedAt'
            ]);

        return $this->transformNewsApiResponse(
            $category->id,
            $response->data['articles']
        );
    }

    protected function syncTheGuardian(Category $category)
    {
        $response = NewsFacade::theGuardian()
            ->list([
                'q' => $category->name,
                'from-date' => now()->format('Y-m-d')
            ]);

        return $this->transformTheGuardianResponse(
            $category->id,
            $response->data['response']['results']
        );
    }

    private function transformNyTimesResponse(int $categoryId, array $articles)
    {
        return collect($articles)->map(function ($article) use ($categoryId) {
            $image = sizeof($article['multimedia']) > 0 ?
                $article['multimedia'][0]['url'] :
                null;

            return [
                'title' => $article['abstract'],
                'description' => $article['lead_paragraph'],
                'category_id' => $categoryId,
                'source' => Article::SOURCE_NY_TIMES,
                'source_link' => $article['web_url'],
                'published_at' => now()->format('Y-m-d H:i:s'),
                'author' => null,
                'image_url' => $image,
                'created_at' => now(),
                'updated_at' => now()
            ];
        })
        ->toArray();
    }

    private function transformNewsApiResponse(int $categoryId, array $articles)
    {
        return collect($articles)->map(function ($article) use ($categoryId) {
            return [
                'title' => $article['title'],
                'description' => $article['description'],
                'category_id' => $categoryId,
                'source' => Article::SOURCE_NEWS_API,
                'source_link' => $article['url'],
                'published_at' => Carbon::parse($article['publishedAt'])->format('Y-m-d H:i:s'),
                'author' => $article['author'],
                'image_url' => $article['urlToImage'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        })
        ->toArray();
    }

    private function transformTheGuardianResponse(int $categoryId, array $articles)
    {
        return collect($articles)->map(function ($article) use ($categoryId) {
            return [
                'title' => $article['webTitle'],
                'description' => null,
                'category_id' => $categoryId,
                'source' => Article::SOURCE_THE_GUARDIAN,
                'source_link' => $article['webUrl'],
                'published_at' => Carbon::parse($article['webPublicationDate'])->format('Y-m-d H:i:s'),
                'author' => null,
                'image_url' => null,
                'created_at' => now(),
                'updated_at' => now()
            ];
        })
        ->toArray();
    }
}
