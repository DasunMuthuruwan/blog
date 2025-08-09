<div>
    <div class="pd-20 card-box mb-30">
        <div class="row mb-20">
            <div class="col-md-4">
                <label for=search"><b class="text-secondary">Search</b>:</label>
                <input type="text" wire:model.live="search" id="search" class="form-control"
                    placeholder="Search posts...">
            </div>
            @if (auth()->user()->type == 'superAdmin')
                <div class="col-md-2">
                    <label for="author" class="text-secondary">Author</label>
                    <select wire:model.live="author" id="author" class="custom-select form-control">
                        <option value="">No selected</option>
                        @foreach (App\Models\User::whereHas('posts')->get() as $author)
                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="col-md-2">
                <label for="category" class="text-secondary">Category</label>
                <select id="category" wire:model.live="category" class="custom-select form-control">
                    <option value="">No selected</option>
                    {!! $categoryHtml !!}
                </select>
            </div>
            <div class="col-md-2">
                <label for="visibility" class="text-secondary">Visibility</label>
                <select id="visibility" wire:model.live="visibility" class="custom-select form-control">
                    <option value="">No selected</option>
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sort_by" class="text-secondary">Sort By</label>
                <select id="sort_by" wire:model.live="sort_by" class="custom-select form-control">
                    <option value="">No selected</option>
                    <option value="asc">ASC</option>
                    <option value="desc">DESC</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table tavle-striped table-auto table-sm">
                <thead class="bg-secondary text-white">
                    <th scope="col">#ID</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Category</th>
                    <th scope="col">Visibility</th>
                    <th scope="col">Action</th>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td scope="row">{{ $post->id }}</td>
                            <td>
                                <a href=''>
                                    <img src="{{ asset("storage/images/posts/resized/resized_{$post->feature_image}") }}"
                                        width="100" alt="post_feature_image_{{ $post->id }}">
                                </a>
                            </td>
                            <td>
                                {{ $post->title }}
                            </td>
                            <td>{{ $post->author->name ?? ' - ' }}</td>
                            <td>{{ $post->post_category->name ?? ' - ' }}</td>
                            <td>
                                @if ($post->visibility == 1)
                                    <span class="badge badge-pill badge-success"><i
                                            class="icon-copy ti-world mr-1"></i>Public</span>
                                @else
                                    <span class="badge badge-pill badge-warning"><i
                                            class="icon-copy ti-lock mr-1"></i>Private</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.post', ['post' => $post->id]) }}" data-color="#265ed7"
                                        style="color: rgb(38,94,215)">
                                        <i class="icon-copy dw dw-edit2"></i>
                                    </a>
                                    @if (auth()->user()->type == 'superAdmin' && !$post->visibility)
                                        <a href="javascript:;" wire:click="approvePost({{ $post->id }})"
                                            data-color="#e95959" style="color: rgb(233,89,89)">
                                            <i class="icon-copy bi bi-check-circle"></i>
                                        </a>
                                    @endif
                                    <a href="javascript:;" wire:click="deletePost({{ $post->id }})"
                                        data-color="#e95959" style="color: rgb(233,89,89)">
                                        <i class="icon-copy dw dw-delete-3"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <span class="text-danger text-center">No post(s) found!</span>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        <div class="block mt-1">
            {{ $posts->links('livewire::simple-bootstrap') }}
        </div>
    </div>
</div>
