<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\ParentCategory;
use App\Models\Post;
use App\Observers\CategoryObserver;
use App\Observers\GeneralSettingObserver;
use App\Observers\ParentCategoryObserver;
use App\Observers\PostObserver;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Redirect an Authenticated user to dashboard
        RedirectIfAuthenticated::redirectUsing(fn() => route('admin.dashboard'));

        // Redirect No Authenticated User to Admin login page
        Authenticate::redirectUsing(function () {
            Session::flash('fail', 'You must be logged in to access admin area. Please login to continue.');

            return route('admin.login');
        });

        GeneralSetting::observe(GeneralSettingObserver::class);
        Category::observe(classes: CategoryObserver::class);
        ParentCategory::observe(classes: ParentCategoryObserver::class);
        Post::observe(PostObserver::class);
    }
}
