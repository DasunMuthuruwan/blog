<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Services\Post\PostService;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = null;
    public $author = null;
    public $category = null;
    public $visibility = null;
    public $sort_by = 'desc';

    public $post_visibility;
    public $categoryHtml;

    protected $queryString = [
        'search' => [
            'except' => ''
        ],
        'author' => [
            'except' => ''
        ],
        'category' => [
            'except' => ''
        ],
        'visibility' => [
            'except' => ''
        ],
        'sort_by' => [
            'except' => ''
        ]
    ];

    protected $listeners = [
        'deletePostAction'
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedAuthor()
    {
        $this->resetPage();
    }

    public function updatedCategory()
    {
        $this->resetPage();
    }

    public function updatedVisibility()
    {
        $this->resetPage();
        $this->post_visibility = $this->visibility == 'public' ? 1 : 0;
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->author = auth()->user()->type == 'superAdmin' ? auth()->user()->id : '';
        $this->post_visibility = $this->visibility == 'public' ? 1 : 0;
        $this->categoryHtml = (new PostService)->generateCategoryHtml();
    }

    public function deletePost(int $postId): void
    {
        $this->dispatch('deletePost', ['id' => $postId]);
    }

    /**
     * Post delete functionality
     * @param int $id
     * @return void
     */
    public function deletePostAction(int $id): void
    {
        try {

            $post = Post::findOrFail($id);
            $path = "storage/images/posts/";
            (new PostService)->deleteFeatureImages($post, ['path' => $path, 'resized_path' => "{$path}resized/"]);

            $post->delete();

            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Post have been deleted successfully.'
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    public function render()
    {
        $query = Post::with(['author', 'post_category'])
            ->search(trim($this->search))
            ->when($this->author, fn($q) => $q->where('author_id', $this->author))
            ->when($this->visibility, fn($q) => $q->where('visibility', $this->post_visibility))
            ->when($this->category, fn($q) => $q->where('category', $this->category))
            ->when($this->sort_by, fn($q) => $q->orderBy('id', $this->sort_by))
            ->clone();

        return view('livewire.admin.posts', [
            'posts' =>
            auth()->user()->type == 'superAdmin'
                ? $query->paginate($this->perPage)
                : $query->where('author_id', auth()->id())->paginate($this->perPage),
        ]);
    }
}
