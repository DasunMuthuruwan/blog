<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class SearchComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $showResults = false;
    protected $queryString = [
        'search' => [
            'except' => ''
        ]
    ];

    public function mount()
    {
        if (!empty($this->search)) {
            $this->showResults = true;
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->showResults = !empty($this->search);
        $this->dispatch('searchUpdated', searchTerm: $this->search, showResults: $this->showResults);
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->showResults = false;
        $this->resetPage();
        $this->dispatch('searchUpdated', searchTerm: '', showResults: false);
    }

    public function render()
    {
        $posts = collect();

        if (!empty($this->search)) {
            $searchTerm = "%{$this->search}%";

            $posts = Post::whereLike('title', $searchTerm)
                ->orWhereLike('content', 'like', $searchTerm)
                ->orWhereLike('tags', 'like', $searchTerm)
                ->with(['author', 'post_category'])
                ->latest()
                ->paginate(3);

            // Add highlighting
            $posts->getCollection()->transform(function ($post) {
                $post->highlighted_title = $this->highlightSearchTerm($post->title, $this->search);
                $post->highlighted_content = $this->highlightSearchTerm(
                    Str::limit(strip_tags($post->content), 150),
                    $this->search
                );

                return $post;
            });
        }

        return view('livewire.search-component', [
            'posts' => $posts,
            'showResults' => $this->showResults
        ]);
    }

    private function highlightSearchTerm($text, $searchTerm)
    {
        if (empty($searchTerm) || empty($text)) {
            return $text;
        }

        return preg_replace(
            '/(' . preg_quote($searchTerm, '/') . ')/i',
            '<span class="search-highlight">$1</span>',
            $text
        );
    }
}
