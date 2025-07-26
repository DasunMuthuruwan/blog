<?php

namespace App\Observers;

use App\Constants\CacheKeys;
use App\Exceptions\CategoryCannotbeDeletedWhenPostsExistsException;
use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function creating(Category $category): void
    {
        cache()->forget(CacheKeys::SITE_NAVIGATIONS);
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updating(Category $category): void
    {
        cache()->forget(CacheKeys::SITE_NAVIGATIONS);
    }

    /**
     * Handle the Category "deleting" event.
     */
    public function deleting(Category $category): void
    {
        // check dependency posts exits for category can not be delete category
        $postCount = $category->posts->count();
        throw_if($postCount > 0, CategoryCannotbeDeletedWhenPostsExistsException::class, "This category has ({$postCount}) related post(s). Can not be deleted.");
        cache()->forget(CacheKeys::SITE_NAVIGATIONS);
    }

    /**
     * Handle the Category "saving" event.
     */
    public function saving(Category $category) {
       cache()->forget(CacheKeys::SITE_NAVIGATIONS);
    }
}
