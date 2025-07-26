<?php

namespace App\Observers;

use App\Constants\CacheKeys;
use App\Models\ParentCategory;

class ParentCategoryObserver
{
    /**
     * Handle the ParentCategory "creating" event.
     */
    public function creating(ParentCategory $parentCategory) {
        cache()->forget(CacheKeys::SITE_NAVIGATIONS);
    }

    /**
     * Handle the ParentCategory "updating" event.
     */
    public function updating(ParentCategory $parentCategory): void
    {
        cache()->forget(CacheKeys::SITE_NAVIGATIONS);
    }

    /**
     * Handle the ParentCategory "deleting" event.
     */
    public function deleting(ParentCategory $parentCategory): void
    {
        cache()->forget(CacheKeys::SITE_NAVIGATIONS);
    }

    /**
     * Handle the ParentCategory "saving" event.
     */
    public function saving(ParentCategory $parentCategory): void
    {
        cache()->forget(CacheKeys::SITE_NAVIGATIONS);
    }
}
