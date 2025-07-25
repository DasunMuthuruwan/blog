<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Exception;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    public function index(Request $request)
    {
        $title = settings()->site_title ?? '';
        $description = settings()->site_meta_description ?? '';
        $imgUrl = settings()->site_logo ? asset("/storage/images/" . settings()->site_logo) : '';
        $keywords = settings()->site_meta_keywords ?? '';
        $currentUrl = url()->current();

        /** Meta  SEO */
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOMeta::setKeywords($keywords);

        /** */
        SEOTools::opengraph()->setUrl($currentUrl);
        SEOTools::opengraph()->addImage($imgUrl);
        SEOTools::opengraph()->addProperty('type', 'articles');

        /** Twitter */
        SEOTools::twitter()->addImage($imgUrl);
        SEOTools::twitter()->setUrl($currentUrl);
        SEOTools::twitter()->setSite('@techSolve');

        /**json-ld */
        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::addImage($imgUrl);

        return view(
            'front.pages.index',
            [
                'pageTitle' => settings()->site_title ?? ''
            ]
        );
    }

    public function categoryPosts(Request $request, $slug = null)
    {
        try {
            // Find Category by slug
            $category = Category::where('slug', $slug)
                ->firstOrFail();

            // Retrieve posts related to this category and paginate
            $posts = Post::visible(1)
                ->with(['author:id,name,username', 'post_category:id,name,slug']) // Eager load relationships
                ->where('category', $category->id)
                ->orderBy('posts.created_at', 'desc')
                ->paginate(8);

            /** Set SEO Meta tags */
            $title = $category->meta_title ?: "Posts in Category: {$category->name}";
            $description = $category->meta_description ?: "Browse the latest posts in the {$category->name} category. {$category->description}";
            $featureImage = $posts->first()->featured_image;
            $canonical = url()->current();

            SEOTools::setTitle($title);
            SEOTools::setDescription($description);
            SEOTools::opengraph()
                ->setUrl($canonical)
                ->addProperty('type', 'website')
                ->setTitle($title)
                ->setDescription($description)
                ->addImage(asset("storage/images/posts/{$featureImage}") ?? asset('images/default-og-image.jpg'));
            SEOTools::twitter()
                ->setType('summary_large_image')
                ->setTitle($title)
                ->setDescription($description)
                ->setImage(asset("storage/images/posts/{$featureImage}") ?? asset('images/default-twitter-image.jpg'));
            SEOTools::jsonLd()
                ->setType('CollectionPage')
                ->setTitle($title)
                ->setDescription($description)
                ->setUrl($canonical);

            return view('front.pages.category_posts', [
                'pageTitle' => $category->name,
                'posts' => $posts
            ]);
        } catch (Exception $exception) {
            dd($exception);
            logger()->error("Category posts error: " . $exception->getMessage());

            return redirect()->route('home')->with('error', 'Category not found');
        }
    }

    public function authorPosts(Request $request, string $username)
    {
        try {
            // Find the author bases on the username
            $author = User::with('social_links')
                ->withCount('posts')
                ->where('username', $username)
                ->firstOrFail();

            // Retrieve posts related to this category and paginate
            $posts = Post::visible(1) // Only published posts
                ->with(['post_category:id,name,slug']) // Eager load categorywhere('author_id', $author->id)
                ->where('author_id', $author->id)
                ->orderBy('created_at')
                ->paginate(8);

            /** Set SEO Meta tags */
            $title = "{$author->name} - Articles & Blog Posts" . (($request->get('page') > 1) ? " (Page " . $request->get('page') . ")" : "");
            $description = $author->bio ?: "Explore all articles and blog posts written by {$author->name}. " .
                "Total {$author->posts_count} posts about various topics.";
            $canonical = route('author_posts', ['username' => $author->username]);
            $featureImage = optional($posts->first())->featured_image ?: $author->picture;

            SEOTools::setTitle($title);
            SEOTools::setDescription($description);
            SEOTools::setCanonical(route('author_posts', ['username' => $author->username]));
            SEOTools::opengraph()->setUrl(route('author_posts', ['username' => $author->username]));
            SEOTools::opengraph()->addProperty('type', 'profile');
            SEOTools::opengraph()
                ->setUrl($canonical)
                ->addProperty('type', 'profile')
                ->setTitle($title)
                ->setDescription($description)
                ->addImage($featureImage)
                ->setProfile([
                    'first_name' => $author->name,
                    'username' => $author->username,
                    'gender' => 'neutral'
                ]);

            // Schema.org/JSON-LD markup
            SEOTools::jsonLd()
                ->setType('Person')
                ->setTitle($title)
                ->setDescription($description)
                ->setUrl($canonical)
                ->addValue('author', [
                    '@type' => 'Person',
                    'name' => $author->name,
                    'url' => $canonical,
                    'image' => $author->avatar
                ]);

            return view('front.pages.author-posts', [
                'pageTitle' => $author->name,
                'author' => $author,
                'posts' => $posts
            ]);
        } catch (Exception $exception) {
            logger()->error("Author posts error: " . $exception->getMessage());

            return redirect()->route('home')->with('error', 'The author you requested was not found');
        }
    }

    public function tagPosts(Request $request, string $tag)
    {
        // Query posts that have the selected tag
        $posts = Post::visible(1)
            ->whereLike('tags', "%{$tag}%")
            ->paginate(8);

        /** For Meta Tags */
        $title = "Posts tagged with {$tag}";
        $description = "Explore all posts tagged with {$tag} on our blog";

        /** Set SEO Meta Tags */
        SEOTools::setTitle($title);
        SEOTools::setDescription($description);
        SEOTools::setCanonical(url()->current());

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type', 'articles');

        return view('front.pages.tag_posts', [
            'pageTitle' => $title,
            'tag' => $tag,
            'posts' => $posts
        ]);
    }
}
