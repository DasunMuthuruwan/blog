<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $settings = settings();
        $title = $settings->site_title ?? '';
        $description = $settings->site_meta_description ?? '';
        $imgUrl = $settings->site_logo ? asset("/storage/images/{$settings->site_logo}") : '';
        $keywords = $settings->site_meta_keywords ?? '';
        $currentUrl = url()->current();
        $popularPosts = Post::query()
            ->select('id', 'category', 'title', 'slug', 'feature_image', 'created_at') // only needed columns
            ->with([
                'author:id,name',
                'post_category:id,name,slug'
            ])
            ->withCount(['views', 'comments']) 
            ->orderByDesc('views_count')
            ->limit(6)
            ->get();

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
        SEOTools::twitter()->setSite('@devTalk');

        /**json-ld */
        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::addImage($imgUrl);

        return view(
            'front.pages.index',
            [
                'pageTitle' => $title,
                'slides' => getSlides(),
                'popularPosts' => $popularPosts
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
                ->with(['author:id,name,username,picture', 'post_category:id,name,slug']) // Eager load relationships
                ->where('category', $category->id)
                ->orderBy('posts.created_at', 'desc')
                ->paginate(8);

            /** Set SEO Meta tags */
            $title = $category->meta_title ?: "Posts in Category: {$category->name}";
            $description = $category->meta_description ?: "Browse the latest posts in the {$category->name} category. {$category->description}";
            $featureImage = $posts->first()->featured_image;
            $canonical = url()->current();

            SEOTools::setTitle($title, false);
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
                ->oldest()
                ->paginate(8);

            /** Set SEO Meta tags */
            $title = "{$author->name} - Articles & Blog Posts" . (($request->get('page') > 1) ? " (Page " . $request->get('page') . ")" : "");
            $description = $author->bio ?: "Explore all articles and blog posts written by {$author->name}. " .
                "Total {$author->posts_count} posts about various topics.";
            $canonical = route('author_posts', ['username' => $author->username]);
            $featureImage = optional($posts->first())->featured_image ?: $author->picture;

            SEOTools::setTitle($title, false);
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
        SEOTools::setTitle($title, false);
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

    public function searchPosts(Request $request)
    {
        // Get search query from the input
        $query = $request->input('q');
        if ($query) {
            $keywords = explode(' ', $query);
            $postsQuery = Post::query();
            foreach ($keywords as $key => $keyword) {
                $postsQuery->orWhereLike('title', "%{$keyword}%")
                    ->orWhereLike('tags', "%{$keyword}%");
            }

            $posts = $postsQuery->where('visibility', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            $title = "Search results for {$query}";
            $description = "Browse search results for $query on our blog";
        } else {
            $posts = collect();

            $title = "Search";
            $description = "Search for blog posts on our website";
        }

        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOTools::jsonLd()->setTitle($title);
        SEOTools::jsonLd()->setDescription($description);
        SEOTools::jsonLd()->addValue('publisher', value: [
            '@type' => 'Organization',
            'name' => config('app.name'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => settings()->site_logo ? asset('storage/images/site/' . settings()->site_logo) : asset('default-logo.png'),
            ]
        ]);

        return view('front.pages.search_posts', [
            'pageTitle' => $title,
            'query' => $query,
            'posts' => $posts
        ]);
    }

    public function readPost(Request $request, string $slug)
    {
        try {
            $post = Post::with(['author:id,name,username,picture', 'post_category:id,name,slug'])
                ->withCount('views', 'comments')
                ->where('slug', $slug)
                ->firstOrFail();

            $cacheKey = 'post_viewed_' . $post->id . '_' . request()->ip();
            if (!Cache::has($cacheKey)) {
                PostView::create([
                    'post_id' => $post->id,
                    // 'user_id' => auth()->id() ?? NULL, // or null if guest
                    'ip_address' => request()->ip(),
                    'viewed_at' => now(),
                ]);
                Cache::put($cacheKey, true, now()->addHours(1));
            }

            $relatedPosts = Post::where('category', $post->category)
                // ->with(['author:id,name,username', 'post_category:id,name,slug']) // Eager load relationships
                ->where('id', '!=', $post->id)
                ->visible(1)
                ->latest()
                ->take(3)
                ->get();

            $nextPost = Post::where('id', '>', $post->id)
                ->visible(1)
                ->oldest()
                ->first();

            $prevPost = Post::where('id', '<', $post->id)
                ->visible(1)
                ->latest()
                ->first();

            /** Set SEO Meta Tags */
            $title = $post->title;
            $description = !empty($post->meta_description)
                ? $post->meta_description : words($post->content, 35);
            $image = asset("storage/images/posts/{$post->feature_image}");
            SEOTools::setTitle($title, false);
            SEOTools::setDescription($description);
            SEOTools::opengraph()->setUrl(route('read_post', $post->slug));
            SEOTools::opengraph()->addProperty('type', 'article');
            SEOTools::opengraph()->addImage($image);
            SEOTools::twitter()->setImage($image);
            SEOTools::jsonLd()->setType('BlogPosting');
            SEOTools::jsonLd()->setTitle($title);
            SEOTools::jsonLd()->setDescription($description);
            SEOTools::jsonLd()->addImage($image);
            SEOTools::jsonLd()->setUrl(route('read_post', $post->slug));
            SEOTools::jsonLd()->addValue('published_at', $post->published_at ?? now());
            SEOTools::jsonLd()->addValue('updated_at', $post->updated_at ?? $post->published_at ?? now());
            SEOTools::jsonLd()->addValue('author', [
                '@type' => 'Person',
                'name' => $post->author->name ?? 'Dasun Muthuruwan'
            ]);
            SEOTools::jsonLd()->addValue('publisher', value: [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('storage/images/site/' . settings()->site_logo),
                ]
            ]);
            SEOTools::jsonLd()->addValue('mainEntityOfPage', [
                '@type' => 'WebPage',
                '@id' => route('read_post', $post->slug)
            ]);


            return view('front.pages.single_post', [
                'pageTitle' => $title,
                'post' => $post,
                'relatedPosts' => $relatedPosts,
                'prevPost' => $prevPost,
                'nextPost' => $nextPost
            ]);
        } catch (Exception $exception) {
            logger()->error("Author posts error: " . $exception->getMessage());

            return redirect()->route('home')->with('error', 'The author you requested was not found');
        }
    }

    public function contactPage(Request $request)
    {
        $title = "Contact Us";
        $description = "Hate Forms? Write Us Email";
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);

        return view('front.pages.contact');
    }

    public function sendEmail(ContactRequest $contactRequest)
    {
        try {

            $data = [
                'name' => $contactRequest->name,
                'email' => $contactRequest->email,
                'subject' => $contactRequest->subject,
                'message' => $contactRequest->message
            ];
            Mail::to(config('app.contact_email'))
                ->queue(new ContactMail($data));

            return redirect()->back()->with('success', 'Email Sent Successfully.');
        } catch (Exception $exception) {
            logger()->error("Author posts error: " . $exception->getMessage());

            return redirect()->route('home')->with('error', 'Something went wrong. Try again later.');
        }
    }
}
