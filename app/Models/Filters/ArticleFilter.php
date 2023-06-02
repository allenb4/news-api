<?php

namespace App\Models\Filters;

use EloquentFilter\ModelFilter;

class ArticleFilter extends ModelFilter
{
    public function title(string $title): self
    {
        return $this->where('title', 'LIKE', '%' . $title . '%');
    }

    public function description(string $description): self
    {
        return $this->where('description', 'LIKE', '%' . $description . '%');
    }

    public function source(string $source): self
    {
        return $this->where('source', $source);
    }

    public function publishedAt(string $published): self
    {
        return $this->whereDate('published_at', $published);
    }

    public function author(string $author): self
    {
        return $this->where('author', 'LIKE', '%' . $author . '%');
    }

    public function category(string $category): self
    {
        return $this->whereHas('categories', function ($query) use ($category) {
            return $query->where('name', 'LIKE', '%' . $category . '%');
        });
    }
}
