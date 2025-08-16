<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index()
    {
        // Cache sitemap for 1 day to avoid regenerating on every request
        return Cache::remember('sitemap.xml', 86400, function () {
            $sitemap = Sitemap::create()
                ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
                ->add(Url::create('/contact')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
                ->add(Url::create('/about')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
                ->add(Url::create('/privacy-policy')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
                ->add(Url::create('/term-conditions')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

            // Fetch only necessary columns to improve query performance
            $posts = Post::with(['post_category:id,slug', 'author:id,username'])
                ->get();

            // Use arrays to avoid duplicate category/author URLs
            $categories = [];
            $authors = [];

            foreach ($posts as $post) {
                // Single post
                $sitemap->add(
                    Url::create(route('read_post', [$post->slug]))
                        ->setPriority(0.7)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                        ->setLastModificationDate($post->updated_at)
                );

                // Category URLs
                if (!in_array($post?->post_category?->slug, $categories)) {
                    $categories[] = $post->post_category->slug;
                    $sitemap->add(
                        Url::create(route('category_posts', [$post->post_category->slug]))
                            ->setPriority(0.6)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    );
                }

                // Author URLs
                if (!in_array($post->author->username, $authors)) {
                    $authors[] = $post->author->username;
                    $sitemap->add(
                        Url::create(route('author_posts', [$post->author->username]))
                            ->setPriority(0.6)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    );
                }
            }

            return response($sitemap->render(), 200)
                ->header('Content-Type', 'text/xml');
        });
    }
}
