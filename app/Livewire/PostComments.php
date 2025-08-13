<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Like;
use Livewire\Component;
use Livewire\WithPagination;

class PostComments extends Component
{
    use WithPagination;

    public $postId;
    public $comment;
    public $replyTexts = [];
    public $activeReplyForm = null;
    public $showReplies = null;

    protected $rules = [
        'comment' => 'required|string|max:500'
    ];

    public function mount($postId)
    {
        $this->postId = $postId;
    }

    public function addComment()
    {
        $this->validate();
        $cleanComment = htmlspecialchars(strip_tags($this->comment), ENT_QUOTES, 'UTF-8');

        Comment::create([
            'post_id' => $this->postId,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'comment' => $cleanComment
        ]);

        $this->reset('comment');
        $this->resetPage(); // Reset pagination to first page
    }

    public function addReply($parentId)
    {
        $this->validate([
            "replyTexts.$parentId" => 'required|string|max:500'
        ]);

        $cleanReply = htmlspecialchars(strip_tags($this->replyTexts[$parentId]), ENT_QUOTES, 'UTF-8');

        Comment::create([
            'post_id' => $this->postId,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'parent_id' => $parentId,
            'comment' => $cleanReply
        ]);

        unset($this->replyTexts[$parentId]);
        $this->activeReplyForm = null;
    }

    public function toggleReplies($commentId)
    {
        $this->showReplies = $this->showReplies === $commentId ? null : $commentId;
    }

    public function toggleReplyForm($commentId)
    {
        $this->activeReplyForm = $this->activeReplyForm === $commentId ? null : $commentId;
    }

    public function toggleLike($commentId)
    {
        $query = Like::where('comment_id', $commentId);

        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('ip_address', request()->ip());
        }

        if ($query->exists()) {
            $query->delete();
        } else {
            Like::create([
                'comment_id' => $commentId,
                'user_id' => auth()->id(),
                'ip_address' => request()->ip()
            ]);
        }
    }

    public function render()
    {
        $comments = Comment::with([
                'user',
                'replies.user',
                'replies.likes',
                'likes'
            ])
            ->withCount(['likes as likes_count', 'replies as replies_count'])
            ->where('post_id', $this->postId)
            ->whereNull('parent_id')
            ->orderByDesc('likes_count')
            ->latest()
            ->paginate(5);

        return view('livewire.post-comments', compact('comments'));
    }
}