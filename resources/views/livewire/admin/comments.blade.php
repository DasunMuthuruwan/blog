<div>
    <div class="card-box pb-20 mb-4">
        <div class="table-responsive mt-3">
            <table class="table table-striped table-auto table-sm table-condensed">
                <thead class="bg-secondary text-white">
                    <th scope="col">#ID</th>
                    <th scope="col">Post Title</th>
                    <th scope="col">Comments</th>
                    <th scope="col">Replies</th>
                    <th scope="col">Likes</th>
                    <th scope="col">Action</th>
                </thead>
                <tbody>
                    @forelse ($comments as $comment)
                        <tr>
                            <td>#{{ $comment->id }}</td>
                            <td>{{ $comment->post->title }}</td>
                            <td>{{ $comment->comment }}</td>
                            <td>
                                @foreach ($comment->replies as $reply)
                                    <div style="margin-left: 20px;">
                                        {{ $reply->comment }}
                                    </div>
                                @endforeach
                            </td>
                            <td>{{ $comment->likes_count }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="javascript:;"
                                        wire:click="$dispatch('deleteComments', {id: {{ $comment->id }} })"
                                        data-color="#e95959" style="color:rgb(233,89,89)" data-placement='top'
                                        title='Delete'>
                                        <i class="icon-copy dw dw-delete-3"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="8" class="text-center"><span class="text-danger">No Comment found!</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-block mt-1 text-center">
        {{ $comments->links('livewire::simple-bootstrap') }}
    </div>
</div>
