<?php

namespace App\Observers;

use App\Constants\CacheKeys;
use App\Models\GeneralSetting;

class GeneralSettingObserver
{
    /**
     * Handle the GeneralSetting "created" event.
     */
    public function creating(GeneralSetting $generalSetting): void
    {
        cache()->forget(CacheKeys::SITE_SETTINGS);
    }

    /**
     * Handle the GeneralSetting "updating" event.
     */
    public function updating(GeneralSetting $generalSetting): void
    {
        cache()->forget(CacheKeys::SITE_SETTINGS);
    }

    /**
     * Handle the GeneralSetting "deleted" event.
     */
    public function deleting(GeneralSetting $generalSetting): void
    {
        cache()->forget(CacheKeys::SITE_SETTINGS);
    }

    /**
     * Handle the GeneralSetting "saving" event.
     */
    public function saving(GeneralSetting $generalSetting): void
    {
        cache()->forget(CacheKeys::SITE_SETTINGS);
    }
}
