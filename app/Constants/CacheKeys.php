<?php

namespace App\Constants;

class CacheKeys
{

    public const SITE_NAVIGATIONS = 'site_navigations'; // site navigations
    public const SITE_SETTINGS = 'site_settings'; // site setting
    public const SITE_SOCIAL_LINKS = 'site_social_links'; // site social links
    public const LATEST_POSTS = 'latest_posts'; // latest posts
    public const SIDEBAR_LATEST_POSTS = 'sidebar_latest_posts'; // latest posts
    public const SIDEBAR_CATEGORIES = 'sidebar_categories'; // sidebar categories

    public const CORNER_AD = 'corner_ad'; // corner ad

    public const POPUP_AD = 'popup_ad'; // popup ad

    public const HOME_SLIDES = 'home_slides';

    // Time durations (in seconds)
    public const SHORT_TERM = 10800; // 3 hour
    public const MEDIUM_TERM = 86400; // 24 hours
    public const LONG_TERM = 604800; // 1 week
}
