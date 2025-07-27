<?php

namespace App\Observers;

use App\Constants\CacheKeys;
use App\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function creating(Post $post): void
    {
        cache()->forget(CacheKeys::SITE_NAVIGATIONS);
        cache()->forget(CacheKeys::LATEST_POSTS);
        cache()->forget(CacheKeys::SIDEBAR_LATEST_POSTS);
        cache()->forget(CacheKeys::SIDEBAR_CATEGORIES);
    }

    /**
     * Handle the Post "saving" event.
     */
    public function saving(Post $post): void
    {
        cache()->forget(CacheKeys::SITE_NAVIGATIONS);
        cache()->forget(CacheKeys::LATEST_POSTS);
        cache()->forget(CacheKeys::SIDEBAR_LATEST_POSTS);
        cache()->forget(CacheKeys::SIDEBAR_CATEGORIES);
    }

    /**
     * Handle the Post "updating" event.
     */
    public function updating(Post $post): void
    {
        cache()->forget(CacheKeys::SITE_NAVIGATIONS);
        cache()->forget(CacheKeys::LATEST_POSTS);
        cache()->forget(CacheKeys::SIDEBAR_LATEST_POSTS);
    }

    /**
     * Handle the Post "deleting" event.
     */
    public function deleting(Post $post): void
    {
        cache()->forget(CacheKeys::SITE_NAVIGATIONS);
        cache()->forget(CacheKeys::LATEST_POSTS);
        cache()->forget(CacheKeys::SIDEBAR_LATEST_POSTS);
        cache()->forget(CacheKeys::SIDEBAR_CATEGORIES);
    }
}
