@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Document title')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8 mb-5 mb-lg-0">
            <!-- Home Content (Default) -->
            <div id="home-content">
                @if (empty($search))
                    <article class="row mb-5">
                        @if (!empty($slides))
                            <div class="col-12">
                                <div class="post-slider">
                                    @foreach ($slides as $slide)
                                        <div class="slider-item">
                                            <img loading="lazy" src='{{ asset("images/slides/{$slide->image}") }}'
                                                class="img-fluid" alt="{{ $slide->heading }}">
                                            <div class="slider-content">
                                                @if ($slide->link)
                                                    <a href="{{ $slide->link }}">
                                                        <h2 class="animated__animated">{{ $slide->heading }}</h2>
                                                    </a>
                                                @else
                                                    <h2 class="animate__animated">{{ $slide->heading }}</h2>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif


                        @foreach (latestPosts(0, 1) as $post)
                            <div class="col-12 mx-auto">
                                <h3>
                                    <a class="post-title" href="{{ route('read_post', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <ul class="list-inline post-meta mb-4">
                                    <li class="list-inline-item"><i class="ti-user mr-1"></i>
                                        <a href="{{ route('author_posts', $post->author->username) }}">
                                            {{ $post->author->name }}
                                        </a>
                                    </li>
                                    <li class="list-inline-item"><i
                                            class="ti-calendar mr-1"></i>{{ dateFormatter($post->created_at) }}</li>
                                    <li class="list-inline-item">Category : <a
                                            href="{{ route('category_posts', $post->post_category->slug) }}"
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
                                    {!! Str::ucfirst(words($post->content, 45)) !!}
                                </p>
                                <a href="{{ route('read_post', $post->slug) }}" class="btn btn-outline-primary">Read
                                    more...</a>
                            </div>
                        @endforeach
                    </article>

                    <section id="home__latest-posts" class="latest-article">
                        @foreach (latestPosts(1, 3) as $latestPost)
                            <article class="row mb-5 letest-result-item">
                                <div class="col-md-4 mb-4 mb-md-0">
                                    <div class="post-img-box">
                                        <img src='{{ asset("storage/images/posts/resized/resized_$latestPost->feature_image") }}'
                                            class="img-fluid rounded-lg" alt="{{ $latestPost->title }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h4>
                                        <a class="post-title" href="{{ route('read_post', $latestPost->slug) }}">
                                            {{ $latestPost->title }}
                                        </a>
                                    </h4>
                                    <ul class="list-inline post-meta mb-2">
                                        <li class="list-inline-item">
                                            <i class="ti-user mr-2"></i>
                                            <a
                                                href="{{ route('author_posts', $latestPost->author->username) }}">{{ $latestPost->author->name }}</a>
                                        </li>
                                        <li class="list-inline-item">{{ dateFormatter($latestPost->created_at) }}</li>
                                        <li class="list-inline-item">Category : <a
                                                href="{{ route('category_posts', $latestPost->post_category->slug) }}"
                                                class="ml-1">
                                                {{ $latestPost->post_category->name }}
                                            </a>
                                        </li>
                                        @php
                                            $duration = readDuration($latestPost->title, $latestPost->content);
                                        @endphp
                                        <li class="list-inline-item">
                                            <i class="ti-timer mr-1"></i>
                                            {{ $duration }}
                                            @choice('min|mins', $duration)
                                        </li>
                                    </ul>
                                    <p>
                                        {!! Str::ucfirst(words($latestPost->content, 30)) !!}
                                    </p>
                                    <a href="{{ route('read_post', $latestPost->slug) }}"
                                        class="btn btn-outline-primary">Read more...</a>
                                </div>
                            </article>
                        @endforeach
                    </section>
                @endif
            </div>

            <!-- Search Results Container (Will be populated by Livewire) -->
            <div id="search-results-container"></div>
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

            <div class="d-flex align-items-center justify-content-center ad-container" style="background-color: #655087; height: 200px;">
                @php
                    $cornerAd = getCornerAd();
                @endphp
                @if ($cornerAd)
                    <div class="w-100 h-100 rounded-lg">
                        @if ($cornerAd->image && $cornerAd->url)
                            {{-- Show image wrapped in a link --}}
                            <a href="{{ e($cornerAd->url) }}" target="_blank" rel="noopener noreferrer">
                                <img src='{{ asset("images/ads/{$cornerAd->image}") }}' alt="Ad" class="img-fluid">
                            </a>
                        @elseif($cornerAd->url && $cornerAd->content)
                            {{-- Show content wrapped in a link --}}
                            <a href="{{ $cornerAd->url }}" target="_blank" rel="noopener noreferrer">
                                {!! $cornerAd->content !!}
                            </a>
                        @endif
                    </div>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 600" class="w-100 h-100 rounded-lg">
                        <rect width="100%" height="100%" fill="#655087" />
                        <text x="50%" y="50%" fill="white" font-size="36" font-family="Arial, sans-serif"
                            text-anchor="middle" dy=".3em">
                            Ad Space
                        </text>
                    </svg>
                @endif
            </div>
        </aside>
    </div>
@endsection
