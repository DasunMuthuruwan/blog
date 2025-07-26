<?php

namespace App\Observers;

use App\Exceptions\CategoryCannotbeDeletedWhenPostsExistsException;
use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "deleting" event.
     */
    public function deleting(Category $category): void
    {
        // check dependency posts exits for category can not be delete category
        $postCount = $category->posts->count();
        throw_if($postCount > 0, CategoryCannotbeDeletedWhenPostsExistsException::class, "This category has ({$postCount}) related post(s). Can not be deleted.");
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
