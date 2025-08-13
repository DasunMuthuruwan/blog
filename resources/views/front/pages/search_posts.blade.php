@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Document title')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection
@section('content')
    <div class="d-flex align-items-center mb-3">
        <h4 class="title-color">Search for:</h4>
        <span class="ml-2">{{ $query }}</span>
    </div>
    <div class="row">
        <div class="col-lg-8 mb-5 mb-lg-0">
            <div class="col-12 mb-5 mb-lg-0">
                @forelse ($posts as $post)
                    <article class="row mb-5 letest-result-item">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="post-img-box">
                                <img loading="lazy" src='{{ asset("storage/images/posts/resized/resized_$post->feature_image") }}'
                                    class="img-fluid rounded-lg" alt="post-thumb">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                <a class="post-title" href="{{ route('read_post', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <ul class="list-inline post-meta mb-2">
                                <li class="list-inline-item">
                                    <i class="ti-user mr-1"></i><a
                                        href="{{ route('author_posts', $post->author->username) }}">{{ $post->author->name }}</a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-calendar mr-1"></i>{{ dateFormatter($post->created_at) }}
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-folder"></i> <a href="{{ route('category_posts', $post->post_category->slug) }}"
                                        class="ml-1">{{ $post->post_category->name }} </a>
                                </li>
                                <li class="list-inline-item">
                                    @php
                                        $duration = readDuration($post->title, $post->content);
                                    @endphp
                                    <i class="ti-timer mr-1"></i> {{ $duration }} | @choice('min|mins', $duration)
                                </li>
                            </ul>
                            <p>
                                {!! Str::ucfirst(words($post->content, 20)) !!}
                            </p>
                            <a href="{{ route('read_post', $post->slug) }}" class="btn btn-outline-primary">Read
                                more...</a>
                        </div>
                    </article>
                @empty
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="ti-search text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="text-muted mb-2">No results found</h5>
                        <p class="text-muted">
                            Try different keywords or check the spelling
                        </p>
                    </div>
                @endforelse
            </div>
            <div class="pagination-block">
                {{ $posts->appends(request()->input())->links('custom-paginations') }}
            </div>
        </div>
        <aside class="col-lg-4">
            <!-- Search Component -->
            <livewire:search-component />

            <!-- categories -->
            <x-sidebar-categories />

            <!-- tags -->
            <x-sidebar-tags />

            <!-- latest post -->
            <x-sidebar-latest-article />
        </aside>
    </div>
@endsection
