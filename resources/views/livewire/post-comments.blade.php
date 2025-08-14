<div>
    <div class="comment-section">
        <!-- New Comment Form -->
        <div class="mb-4">
            <div class="d-flex gap-3">
                <img src="{{ asset('images/users/default-profile.jpg') }}" width="25" height="25" loading="lazy" alt="User Avatar"
                    class="user-avatar">
                <div class="flex-grow-1">
                    <textarea class="form-control comment-input" wire:model="comment" rows="3" placeholder="Write a comment..."></textarea>
                    @error('comment')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    <div class="mt-3 text-end">
                        <button class="btn btn-comment text-white" wire:click.prevent="addComment"
                            wire:loading.attr="disabled" wire:target="addComment">
                            <i class="fas fa-paper-plane me-2"></i>
                            <span wire:loading.remove wire:target="addComment">Post Comment</span>
                            <span wire:loading wire:target="addComment">
                                <span class="spinner-border spinner-border-sm me-2"></span>Posting...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments List -->
        <div class="comments-list">
            <!-- Comment 1 -->
            @forelse ($comments as $comment)
                <div class="comment-box">
                    <div class="d-flex gap-3">
                        <img src='{{ asset('images/users/default-profile.jpg') }}' loading="lazy" alt="User Avatar"
                            class="user-avatar">
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">{{ $comment->user->name ?? 'Guest' }}</h6>
                                <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mb-2">{{ $comment->comment }}</p>
                            <div class="comment-actions">
                                <a wire:click.prevent="toggleLike({{ $comment->id }})" wire:loading.attr="disabled"
                                    wire:target="toggleLike({{ $comment->id }})"><i class="bi bi-heart"></i>
                                    @if ($comment->likes->contains('ip_address', request()->ip()) || $comment->likes->contains('user_id', auth()->id()))
                                        <i class="ti ti-heart text-danger"></i>
                                    @else
                                        <i class="ti ti-heart mr-1"></i>
                                    @endif
                                    <span>({{ $comment->likes_count }})</span>
                                </a>
                                <a wire:click.prevent="toggleReplyForm({{ $comment->id }})"
                                    wire:loading.attr="disabled" wire:target="toggleReplyForm({{ $comment->id }})">
                                    <span wire:loading.remove wire:target="toggleReplyForm({{ $comment->id }})">
                                        <i class="bi bi-reply"></i>
                                        Reply
                                    </span>
                                    <span wire:loading wire:target="toggleReplyForm({{ $comment->id }})">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </span>
                                </a>

                                {{-- Show Replies Count & Collapse --}}
                                @if ($comment->replies_count > 0)
                                    <a class="mr-1" wire:click.prevent="toggleReplies({{ $comment->id }})"
                                        wire:loading.attr="disabled" wire:target="toggleReplies({{ $comment->id }})"
                                        type="button">
                                        <span wire:loading.remove wire:target="toggleReplies({{ $comment->id }})">
                                            <i class="fas fa-comments me-1"></i>
                                            {{ Str::plural('Replies', $comment->replies_count) }}
                                            ({{ $comment->replies_count }})
                                        </span>
                                        <span wire:loading wire:target="toggleReplies({{ $comment->id }})">
                                            <span class="spinner-border spinner-border-sm me-1"></span>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Reply Form --}}
                    @if ($activeReplyForm === $comment->id)
                        <div class="mt-3 ps-3 border-start">
                            <textarea class="form-control mb-2" wire:model="replyTexts.{{ $comment->id }}" placeholder="Write a reply..."
                                rows="2"></textarea>
                            @error("replyTexts.$comment->id")
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror

                            <div class="d-flex gap-2">
                                <a class="btn btn-comment text-white mr-1"
                                    wire:click.prevent="addReply({{ $comment->id }})" wire:loading.attr="disabled"
                                    wire:target="addReply({{ $comment->id }})">
                                    <span wire:loading.remove wire:target="addReply({{ $comment->id }})">
                                        <i class="fas fa-paper-plane me-1"></i>
                                        Post Reply
                                    </span>
                                    <span wire:loading wire:target="addReply({{ $comment->id }})">
                                        <span class="spinner-border spinner-border-sm me-1"></span>
                                        Posting...
                                    </span>
                                </a>
                                <a class="btn btn-sm btn-outline-secondary"
                                    wire:click.prevent="$set('activeReplyForm', null)" type="button">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Reply Section -->
                    @if ($showReplies === $comment->id)
                        <div class="reply-section mt-3">
                            @foreach ($comment->replies as $reply)
                                <div class="comment-box">
                                    <div class="d-flex gap-3">
                                        <img src="{{ asset('images/users/default-profile.jpg') }}" loading="lazy"
                                            alt="User Avatar" class="user-avatar">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">{{ $reply->user->name ?? 'Guest' }}</h6>
                                                <span
                                                    class="comment-time">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="mb-2">{{ $reply->comment }}
                                            </p>
                                            <div class="comment-actions">
                                                <a wire:click.prevent="toggleLike({{ $reply->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="toggleLike({{ $reply->id }})">
                                                    <i class="bi bi-heart"></i> Like
                                                    <span wire:loading.remove
                                                        wire:target="toggleLike({{ $reply->id }})">
                                                        @if ($reply->likes->contains('ip_address', request()->ip()) || $reply->likes->contains('user_id', auth()->id()))
                                                            <i class="bi bi-heart text-danger"></i>
                                                        @else
                                                            <i class="bi bi-heart small"></i>
                                                        @endif
                                                        ({{ $reply->likes->count() }})
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="alert alert-info">
                    No comments yet. Be the first to comment!
                </div>
            @endforelse

            <div class="pagination-block">
                {{ $comments->links('custom-pagination-livewire') }}
            </div>
        </div>
    </div>
</div>
