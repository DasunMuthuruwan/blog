<div>
    <!-- Search Widget in Sidebar -->
    <div class="widget">
        <h5 class="widget-title"><span>Search</span></h5>
        <div class="widget-search">
            <div class="search-input-wrapper">
                <input type="search" wire:model.live.debounce.300ms="search"
                    placeholder="Type to discover articles, guide &amp; tutorials..." class="search-input"
                    autocomplete="off">
                <button type="button" wire:click="clearSearch">
                    <i class="ti-close text-dark"></i>
                </button>
                <button type="button" class="search-btn">
                    <i class="ti-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Search Results Display (Hidden by default, shown in main content) -->
    @if ($showResults && $search)
        <div class="search-results-section">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center">
                    <h6 class="title-color mb-0">Search Results for:</h6>
                    <span class="ml-1 font-weight-bold text-primary text-xs">"{{ $search }}"</span>
                </div>
                <div class="text-muted text-xs">
                    {{ $posts->total() }} result{{ $posts->total() != 1 ? 's' : '' }} found
                </div>
            </div>

            @if ($posts->count() > 0)
                @foreach ($posts as $post)
                    <article class="row mb-5 search-result-item">
                        {{-- <div class="col-md-6 mb-4 mb-md-0">
                            <div class="post-img-box">
                                <a href="{{ route('read_post', $post->slug) }}">
                                    <img src="{{ asset("storage/images/posts/resized/resized_$post->feature_image") }}"
                                        class="img-fluid rounded-lg" alt="{{ $post->title }}" loading="lazy">
                                </a>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <h5>
                                <a class="post-title" href="{{ route('read_post', $post->slug) }}">
                                    {!! $post->highlighted_title !!}
                                </a>
                            </h5>
                            <ul class="list-inline post-meta mb-2">
                                <li class="list-inline-item">
                                    <i class="ti-user mr-1"></i>
                                    <a href="{{ route('author_posts', $post->author->username) }}">
                                        {{ $post->author->name }}
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-calendar mr-1"></i>{{ dateFormatter($post->created_at) }}
                                </li>
                                <li class="list-inline-item">
                                    Category : <a href="{{ route('category_posts', $post->post_category->slug) }}"
                                        class="ml-1">
                                        {{ $post->post_category->name }}
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-timer mr-1"></i>
                                    {{ readDuration($post->title, $post->content) }}
                                    @choice('min|mins', readDuration($post->title, $post->content))
                                </li>
                            </ul>
                            <p>
                                {!! $post->highlighted_content !!}
                            </p>
                            <a href="{{ route('read_post', $post->slug) }}" class="btn btn-outline-primary">
                                Read more...
                            </a>
                        </div>
                    </article>
                @endforeach

                <div class="pagination-block">
                    {{ $posts->links('custom-pagination-livewire') }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="ti-search text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-muted mb-2">No results found</h5>
                    <p class="text-muted">
                        Try different keywords or check the spelling
                    </p>
                </div>
            @endif
        </div>
    @endif
</div>