<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\ParentCategory;
use App\Models\Post;
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

    public function mount()
    {
        $this->post_visibility = $this->visibility == 'public' ? 1 : 0;
        $categoryHtml = "";
        $pCategories = ParentCategory::whereHas('children', function ($subQuery) {
            $subQuery->whereHas('posts');
        })
            ->orderBy('name', 'asc')
            ->cursor();

        $categories = Category::whereHas('posts')->where('parent', 0)->orderBy('name', 'asc')->cursor();

        if (sizeof($pCategories) > 0) {
            foreach ($pCategories as $key => $pCategory) {
                $categoryHtml .= '<optgroup label="' . $pCategory->name . '">';
                foreach ($pCategory->children as $key => $children) {
                    if ($children->posts->count() > 0) {
                        $categoryHtml .= '<option value="' . $children->id . '">' . $children->name . '</option>';
                    }
                }
                $categoryHtml .= '</optgroup>';
            }
        }

        if (sizeof($categories) > 0) {
            foreach ($categories as $key => $category) {
                $categoryHtml .= "<option value='{{ $category->id }}'>{{$category->name}}</option>";
            }
        }

        $this->categoryHtml = $categoryHtml;
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
