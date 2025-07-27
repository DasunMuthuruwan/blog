<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use Sluggable;

    protected $fillable = [
        'author_id',
        'title',
        'category',
        'slug',
        'content',
        'feature_image',
        'tags',
        'meta_keywords',
        'meta_description',
        'visibility',
        'is_notified'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function post_category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }

    /**
     * Scope a query to get search posts.
     * @param Builder $query
     * @param string $search
     */
    #[Scope]
    protected function search(Builder $query, string $search): void
    {
        $query->whereLike('title', "%{$search}%")
            ->orWhereLike('content', "%{$search}%")
            ->orWhereLike('tags', "%{$search}%");
    }

    /**
     * Scope a query to get visibility posts.
     * @param Builder $query
     * @param int $visibility
     */
    #[Scope]
    protected function visible(Builder $query, int $visibility) {
        $query->where('visibility', $visibility);
    }
}
