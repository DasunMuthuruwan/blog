<?php

namespace App\Http\Controllers;

use App\Exceptions\FailedOnCreatedException;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileUploadFailedException;
use App\Helpers\ApiResponse;
use App\Http\Requests\Post\PostStoreRequest;
use App\Models\Category;
use App\Models\ParentCategory;
use App\Services\Post\PostService;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected string $serverError;

    public function __construct(private PostService $postService)
    {
        $this->serverError = config('exception-errors.errors.server-error');
    }

    public function addPost(Request $request)
    {
        try {

            return view('back.pages.posts.add_post', [
                'pageTitle' => 'Add new post',
                'categories_html' => $this->postService->generateCategoryHtml()
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with(['error' => $this->serverError]);
        }
    }

    public function createPost(PostStoreRequest $postStoreRequest)
    {
        try {
            return ApiResponse::success($this->postService->create($postStoreRequest), "New post has been created successfully.");
        } catch (
            FileNotFoundException |
            FileUploadFailedException |
            FailedOnCreatedException $exception
        ) {
            return ApiResponse::error($exception->getMessage(), 500);
        } catch (Exception $exception) {
            return ApiResponse::error($this->serverError, 500);
        }
    }
}
