<?php

namespace App\Http\Controllers;

use App\Exceptions\FailedOnCreatedException;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileUploadFailedException;
use App\Helpers\ApiResponse;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\ParentCategory;
use App\Models\Post;
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

    public function allPosts(Request $request)
    {
        try {
            return view('back.pages.posts.index', [
                'pageTitle' => 'Posts'
            ]);
        } catch (Exception $exception) {
            return redirect()->back()->with(['error' => $this->serverError]);
        }
    }

    public function editPost(Request $request, Post $post)
    {
        return view('back.pages.posts.edit_post', [
            'pageTitle' => 'Edit post',
            'post' => $post,
            'categories_html' => $this->postService->generateCategoryHtml($post)
        ]);
    }

    public function updatePost(PostUpdateRequest $postUpdateRequest, Post $post)
    {
        try {
            $response = $this->postService->updatePost($postUpdateRequest, $post);

            return ApiResponse::success($response['data'], "Post has been updated successfully.");
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
