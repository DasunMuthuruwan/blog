<?php

use App\Constants\CacheKeys;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\ParentCategory;
use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Site information
 */
if (!function_exists('settings')) {
    function settings()
    {
        $settings = Cache::remember(CacheKeys::SITE_SETTINGS, CacheKeys::MEDIUM_TERM, fn() => GeneralSetting::first());

        if ($settings) {
            return $settings;
        }
    }
}

/**
 * Dynamic navigatuin menus
 */
if (!function_exists('navigations')) {
    function navigations(): string
    {
        // Cache the results for better performance (adjust time as needed)
        return Cache::remember(CacheKeys::SITE_NAVIGATIONS, CacheKeys::MEDIUM_TERM, function () {
            $navigationHtml = '';

            // Optimized query for parent categories with eager loading
            $pCategories = ParentCategory::query()
                ->whereHas('children.posts')
                ->with(['children' => function ($query) {
                    $query->whereHas('posts')
                        ->orderBy('name', 'asc');
                }])
                ->orderBy('name', 'asc')
                ->get();

            // Optimized query for standalone categories
            $categories = Category::query()
                ->whereHas('posts')
                ->where('parent', 0)
                ->orderBy('name', 'asc')
                ->get();

            // Build parent categories with dropdowns
            if ($pCategories->isNotEmpty()) {
                foreach ($pCategories as $category) {
                    $navigationHtml .= '
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                ' . e($category->name) . ' <i class="ti-angle-down ml-1"></i>
                            </a>
                            <div class="dropdown-menu">';

                    foreach ($category->children as $child) {
                        $navigationHtml .= '<a class="dropdown-item" href="'.route('category_posts', $child->slug).'">'
                            . e($child->name) . '</a>';
                    }

                    $navigationHtml .= '</div></li>';
                }
            }

            // Build standalone categories
            if ($categories->isNotEmpty()) {
                foreach ($categories as $category) {
                    $navigationHtml .= '
                        <li class="nav-item">
                            <a class="nav-link" href="'.route('category_posts', $category->slug).'">
                                ' . e($category->name) . '
                            </a>
                        </li>';
                }
            }

            return $navigationHtml;
        });
    }

    /**
     * DATE FORMAT
     */
    if (!function_exists('dateFormatter')) {
        function dateFormatter($value): string
        {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->isoFormat('LL');
        }
    }

    /**
     * STRIP WORDS
     */
    if (!function_exists('words')) {
        function words($value, $words = 15, $end = '...'): string
        {
            return Str::words(strip_tags($value), $words, $end);
        }
    }

    /**
     * CALCULATE POST READ DURATION
     */
    if (!function_exists('readDuration')) {
        function readDuration(...$text)
        {
            Str::macro('timeCounter', function () use ($text) {
                $totalWords = str_word_count(implode(" ", $text));
                $minutesToRead = round($totalWords / 200);

                return (int) max(1, $minutesToRead);
            });

            return Str::timeCounter($text);
        }
    }

    /**
     * DISPLAY LATEST POSTS ON HOMEPAGE
     */
    if (!function_exists('latestPosts')) {
        function latestPosts($skip = 0, $limit = 5): object
        {
            return Cache::remember('', CacheKeys::LATEST_POSTS, function () use ($skip, $limit) {
                return Post::visible(1)
                    ->orderBy('created_at', 'desc')
                    ->skip($skip)
                    ->limit($limit)
                    ->get();
            });
        }
    }

    /**
     * LISTING CATEGORIES WITH NUMBER OF POSTS ON SIDEBAR
     */
    if (!function_exists('sidebarCategories')) {
        function sidebarCategories($limit = 8): object
        {
            return Cache::remember(CacheKeys::SIDEBAR_CATEGORIES, CacheKeys::SHORT_TERM, function () use ($limit) {
                return Category::withCount('posts')->having('posts_count', '>', 0)
                    ->limit($limit)
                    ->orderBy('posts_count', 'desc')
                    ->get();
            });
        }
    }

    /**
     * FETCH ALL TAGS FROM 'posts' TABLE
     *
     * @param int|null $limit Maximum number of tags to return
     * @return array
     */
    if (!function_exists('getTags')) {
        function getTags(?int $limit = null): array
        {
            // Get all non-empty tags in one query
            $tags = Post::whereNotNull('tags')
                ->where('tags', '!=', '')
                ->pluck('tags')
                ->flatMap(function ($tagsString) {
                    return array_map('trim', explode(',', $tagsString));
                })
                ->unique()
                ->sort()
                ->values();

            // Apply limit if specified
            if ($limit) {
                $tags = $tags->take($limit);
            }

            return $tags->all();
        }
    }
}
