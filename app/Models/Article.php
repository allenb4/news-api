<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use EloquentFilter\Filterable;

class Article extends Model
{
    use HasFactory, Filterable;

    const SOURCE_NY_TIMES = 'Ny Times';
    const SOURCE_NEWS_API = 'News API';
    const SOURCE_THE_GUARDIAN = 'The Guardian';

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'source',
        'source_link',
        'published_at',
        'author'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePreferences(Builder $query, array $categories): void
    {
        $query->where('category_id', $categories);
    }
}
