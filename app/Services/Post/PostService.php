<?php

namespace App\Services\Post;

use App\Exceptions\FailedOnCreatedException;
use App\Exceptions\FailedOnUpdatedException;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileUploadFailedException;
use App\Jobs\SendNewsletterJob;
use App\Models\Category;
use App\Models\NewsLetterSubscriber;
use App\Models\ParentCategory;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PostService
{
    /**
     * Get select option dropdown data for catrgories
     * @param ?Post $post
     * 
     * @return string
     */
    public function generateCategoryHtml(?Post $post = null): string
    {
        $categoryHtml = '';

        // Eager load children to prevent N+1 queries
        $parentCategories = ParentCategory::with(['children' => function ($query) {
            $query->orderBy('name', 'asc');
        }])
            ->whereHas('children')
            ->orderBy('name', 'asc')
            ->cursor();

        $categories = Category::where('parent', 0)
            ->orderBy('name', 'asc')
            ->cursor();

        foreach ($parentCategories as $pCategory) {
            $categoryHtml .= "<optgroup label='" . e($pCategory->name) . "'>";
            foreach ($pCategory->children as $category) {
                $selected = $category->id == optional($post)->category ? 'selected' : '';
                $categoryHtml .= "<option value='" . e($category->id) . "' $selected>" . e($category->name) . "</option>";
            }
            $categoryHtml .= '</optgroup>';
        }

        foreach ($categories as $category) {
            $selected = $category->id == optional($post)->category ? 'selected' : '';
            $categoryHtml .= "<option value='" . e($category->id) . "' $selected>" . e($category->name) . "</option>";
        }

        return $categoryHtml;
    }

    public function create(object $request): Post
    {
        $newFileName = $this->imageUpload($request);
        $created = Post::create([
            'author_id' => auth()->id(),
            'category' => $request->category,
            'title' => $request->title,
            'content' => $request->content,
            'feature_image' => $newFileName,
            'tags' => $request->tags,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'visibility' => $request->visibility
        ]);

        if ($request->visibility == 1) {
            // Get post details
            $latestPost = Post::latest()->first();
            $this->sendNewsletterForSubscribers($latestPost);
        }

        throw_if(!$created, FailedOnCreatedException::class, 'Unable to create the post due to an error.');

        return $created;
    }

    /**
     * post update functionality
     * @param object $request
     * @param object $post
     * @return array
     */
    public function updatePost(object $request, object $post): array
    {
        $featureImageName = $post->feature_image;

        if ($request->hasFile('feature_image')) {
            $featureImageName = $this->imageUpload($request, $post);
        }

        $sendEmailToSubscribers =
            ($post->visibility == 0 &&
                $post->is_notified == 0 &&
                $request->visibility == 1)
            ? true
            : false;

        // Post update
        $updated = $post->update([
            'category' => $request->category,
            'title' => $request->title,
            'content' => $request->content,
            'feature_image' => $featureImageName,
            'slug' => null,
            'tags' => $request->tags,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'visibility' => $request->visibility
        ]);

        throw_if(!$updated, FailedOnUpdatedException::class, 'Unable to update the post due to an error.');

        /**
         * Send newsletter to subscriber
         */
        $sendEmailToSubscribers && $this->sendNewsletterForSubscribers($post);

        return [
            'data' => $post
        ];
    }

    /**
     * Summary of sendNewsletterForSubscribers
     * @param object $latestPost
     * @return void
     */
    public function sendNewsletterForSubscribers(object $latestPost): void
    {
        if (NewsLetterSubscriber::exists()) {
            $subscribers = NewsLetterSubscriber::pluck('email');
            foreach ($subscribers as $key => $email) {
                SendNewsletterJob::dispatch($email, $latestPost);
                $latestPost->is_notified = true;
                $latestPost->save();
            }
        }
    }

    /**
     * Upload feature image functionality
     * @param object $request
     * @param mixed $post
     * @return string
     */
    private function imageUpload(object $request, ?object $post = null): string
    {
        $path = "storage/images/posts/";
        $file = $request->file('feature_image');
        $filename = $file->getClientOriginalName();
        $newFileName = time() . "_{$filename}";
        $upload = $file->move(public_path($path), $newFileName);

        throw_if(!$upload, FileUploadFailedException::class, 'File upload failed.');

        /**
         * Generate resized image and thumbnail
         */
        $resized_path = "{$path}resized/";
        if (!File::isDirectory($resized_path)) {
            File::makeDirectory($resized_path, 0777, true, true);
        }
        $manager = new ImageManager(new Driver());

        // Thumbnail (Aspect ratio: 1)
        $image = $manager->read("{$path}{$newFileName}");
        $image->scale(250, 250);
        $image->save("{$resized_path}thumb_{$newFileName}");

        // Thumbnail (Aspect ratio: 1.6)
        $image = $manager->read("{$path}{$newFileName}");
        $image->scale(512, 320);
        $image->save("{$resized_path}resized_{$newFileName}");

        // Delete old feature path
        $post && $this->deleteFeatureImages($post, ['path' => $path, 'resized_path' => "{$path}resized/"]);

        return $newFileName;
    }

    /**
     * Delete feature image when update or delete functionality
     * @param object $post
     * @param array $path
     * @return void
     */
    public function deleteFeatureImages(object $post, array $path): void
    {
        $oldImage = optional($post)->feature_image;
        // Delete old feature path
        if ($oldImage && File::exists(public_path("{$path['path']}{$oldImage}"))) {
            File::delete(public_path("{$path['path']}{$oldImage}"));

            //Delete resized path
            if (File::exists(public_path("{$path['resized_path']}resized_{$oldImage}"))) {
                File::delete(public_path("{$path['resized_path']}resized_{$oldImage}"));
            }

            //Delete thumnail
            if (File::exists(public_path("{$path['resized_path']}thumb_{$oldImage}"))) {
                File::delete(public_path("{$path['resized_path']}thumb_{$oldImage}"));
            }
        }
    }
}
