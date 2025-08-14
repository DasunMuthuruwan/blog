<?php

namespace App\Livewire\Admin;

use App\Models\Comment;
use Exception;
use Livewire\Component;

class Comments extends Component
{

    protected $listeners = [
        'deleteCommentAction'
    ];

    public function deleteCommentAction(int $id)
    {
        try {
            $comment = Comment::find($id);

            // Delete replies
            $comment->replies()->delete();
            $comment->likes()->delete();
            $comment->delete();

            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Comment have been deleted successfully.'
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
        return view('livewire.admin.comments', [
            'comments' => Comment::with([
                'user:id,name',
                'post:id,title',
                'replies',
                'likes'
                
            ])
            ->withCount(['likes'])
            ->whereNull('parent_id')
            ->latest()
            ->paginate(5)
        ]);
    }
}
