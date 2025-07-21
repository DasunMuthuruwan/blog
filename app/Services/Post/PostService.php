<?php

namespace App\Services\Post;

use App\Exceptions\FailedOnCreatedException;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileUploadFailedException;
use App\Models\Category;
use App\Models\ParentCategory;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PostService
{
    /**
     * Get select option dropdown data for catrgories
     * @return string
     */
    public function generateCategoryHtml(): string
    {
        $categoryHtml = '';

        // Eager load children to prevent N+1 queries
        $parentCategories = ParentCategory::with(['children' => function ($query) {
            $query->orderBy('name', 'asc');
        }])
            ->whereHas('children')
            ->orderBy('name', 'asc')
            ->get();

        $categories = Category::where('parent', 0)
            ->orderBy('name', 'asc')
            ->get();

        foreach ($parentCategories as $pCategory) {
            $categoryHtml .= "<optgroup label='" . e($pCategory->name) . "'>";
            foreach ($pCategory->children as $category) {
                $categoryHtml .= "<option value='" . e($category->id) . "'>" . e($category->name) . "</option>";
            }
            $categoryHtml .= '</optgroup>';
        }

        foreach ($categories as $category) {
            $categoryHtml .= "<option value='" . e($category->id) . "'>" . e($category->name) . "</option>";
        }

        return $categoryHtml;
    }

    public function create(object $request): Post
    {

        throw_if(!$request->hasFile('feature_image'), FileNotFoundException::class, 'File not found.');

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
        if(!File::isDirectory($resized_path)){
            File::makeDirectory($resized_path, 0777, true, true);
        }
        $manager = new ImageManager(new Driver());

        // Thumbnail (Aspect ratio: 1)
        $image = $manager->read("{$path}{$newFileName}");
        $image->scale(250,250);
        $image->save("{$resized_path}thumb_{$newFileName}");

        // Thumbnail (Aspect ratio: 1.6)
        $image = $manager->read("{$path}{$newFileName}");
        $image->scale(512,320);
        $image->save("{$resized_path}resized_{$newFileName}");

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

        throw_if(!$created, FailedOnCreatedException::class, 'Unable to create the post due to an error.');

        return $created;
    }
}
