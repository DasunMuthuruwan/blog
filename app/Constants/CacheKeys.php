<?php

namespace App\Constants;

class CacheKeys
{

    public const SITE_NAVIGATIONS = 'site_navigations'; // site navigations
    public const SITE_SETTINGS = 'site_settings'; // site setting
    public const LATEST_POSTS = 'latest_posts'; // latest posts
    public const SIDEBAR_CATEGORIES = 'sidebar_categories'; // sidebar categories

    // Time durations (in seconds)
    public const SHORT_TERM = 10800; // 3 hour
    public const MEDIUM_TERM = 86400; // 24 hours
    public const LONG_TERM = 604800; // 1 week
}
