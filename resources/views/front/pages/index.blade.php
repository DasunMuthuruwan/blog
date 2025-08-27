@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Document title')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection
@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('front/css/popular_posts.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-8 mb-5 mb-lg-0">
            <!-- Home Content (Default) -->
            <div id="home-content">
                <article class="row mb-5">
                    @if (!empty($slides))
                        <div class="col-12">
                            <div class="post-slider">
                                @foreach ($slides as $index => $slide)
                                    <div class="slider-item">
                                        <img @if ($index === 0) loading="eager" fetchpriority="high"
                                             @else
                                                loading="lazy" @endif
                                            src='{{ asset("images/slides/{$slide->image}") }}' class="img-fluid"
                                            width="1200" height="650" alt="{{ $slide->heading }}">
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
                        @php
                            $postAuthor = $post->author;
                            $postCategory = $post->post_category;
                        @endphp
                        <div class="col-12 mx-auto">
                            <h3>
                                <a class="post-title" href="{{ route('read_post', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <ul class="list-inline post-meta mb-4 text-primary">
                                <li class="list-inline-item">
                                    <a href="{{ route('author_posts', $post->author->username) }}">
                                        <img src='{{ asset($post->author->picture) }}' loading="lazy" alt="User Avatar"
                                            class="profile-avatar mb-1" width="10" height="10">
                                        <a class="text-primary" href="{{ route('author_posts', $postAuthor->username) }}">
                                            {{ $postAuthor->name }}
                                        </a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa fa-calendar mb-1 mr-1"></i>{{ dateFormatter($post->created_at) }}
                                </li>
                                <li class="list-inline-item"><i class="fa fa-folder"></i> <a
                                        href="{{ route('category_posts', $postCategory->slug) }}"
                                        class="text-primary ml-1">
                                        {{ $postCategory->name }}
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fa fa-hourglass-half"></i>
                                    {{ readDuration($post->title, $post->content) }}
                                    @choice('min|mins', readDuration($post->title, $post->content))
                                </li>
                            </ul>
                            <p>
                                {!! Str::ucfirst(words($post->content, 45)) !!}
                            </p>
                            <a href="{{ route('read_post', $post->slug) }}"
                                class="btn btn-outline-primary text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-2 text-decoration-none fs-7">Read
                                more...</a>
                        </div>
                    @endforeach
                </article>

                <section id="home__latest-posts" class="latest-article">
                    @foreach (latestPosts(1, 4) as $latestPost)
                        @php
                            $latestPostAuthor = $latestPost->author;
                            $latestPostCategory = $latestPost->post_category;
                        @endphp
                        <article class="row mb-5 letest-result-item">
                            <div class="col-md-4 mb-4 mb-md-0">
                                <div class="post-img-box">
                                    <img loading="lazy"
                                        src='{{ asset("storage/images/posts/resized/resized_{$latestPost->feature_image}") }}'
                                        class="img-fluid rounded-lg" alt="{{ $latestPost->title }}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h4>
                                    <a class="post-title" href="{{ route('read_post', $latestPost->slug) }}">
                                        {{ $latestPost->title }}
                                    </a>
                                </h4>
                                <ul class="list-inline post-meta mb-2 text-primary">
                                    <li class="list-inline-item">
                                        <a href="{{ route('author_posts', $post->author->username) }}">
                                            <img src='{{ asset($post->author->picture) }}' loading="lazy" alt="User Avatar"
                                                class="profile-avatar mb-1" width="10" height="10">
                                            <a class="text-primary"
                                                href="{{ route('author_posts', $latestPostAuthor->username) }}">{{ $latestPostAuthor->name }}</a>
                                    </li>
                                    <li class="list-inline-item"><i
                                            class="fa fa-calendar mr-1"></i>{{ dateFormatter($latestPost->created_at) }}
                                    </li>
                                    <li class="list-inline-item"><i class="fa fa-folder"></i> <a
                                            href="{{ route('category_posts', $latestPostCategory->slug) }}"
                                            class="ml-1 text-primary">
                                            {{ $latestPostCategory->name }}
                                        </a>
                                    </li>
                                    @php
                                        $duration = readDuration($latestPost->title, $latestPost->content);
                                    @endphp
                                    <li class="list-inline-item">
                                        <i class="fa fa-hourglass-half"></i>
                                        {{ $duration }}
                                        @choice('min|mins', $duration)
                                    </li>
                                </ul>
                                <p>
                                    {!! Str::ucfirst(words($latestPost->content, 30)) !!}
                                </p>
                                <a href="{{ route('read_post', $latestPost->slug) }}"
                                    class="btn btn-outline-primary text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-2 text-decoration-none fs-7">Read
                                    more...</a>
                            </div>
                        </article>
                    @endforeach
                </section>
                <!-- Blog 5 - Bootstrap Brain Component -->
                <section class="bsb-blog-5 py-3 py-md-1 py-xl-8 mb-5">
                    <div class="container">
                        <div class="row justify-content-md-center">
                            <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                                <h2 class="display-5 mb-4 mb-md-5 text-center">Popular Articles</h2>
                                <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
                            </div>
                        </div>
                    </div>

                    <div class="container overflow-hidden">
                        <div class="row gy-4 gy-md-5 gx-xl-6 gy-xl-6 gx-xxl-9 gy-xxl-9">
                            @foreach ($popularPosts as $popularPost)
                                <div class="col-12 col-lg-4 mb-5">
                                    <article>
                                        <div class="card border-0 bg-transparent">
                                            <figure class="card-img-top mb-4 overflow-hidden bsb-overlay-hover">
                                                <a href="{{ route('read_post', $popularPost->slug) }}">
                                                    <img class="img-fluid bsb-scale bsb-hover-scale-up" loading="lazy"
                                                        src='{{ asset("storage/images/posts/resized/resized_{$popularPost->feature_image}") }}'
                                                        alt="post-thumb" />
                                                </a>
                                                <figcaption>
                                                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                        fill="currentColor" class="bi bi-eye text-white bsb-hover-fadeInLeft"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                        <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                    </svg> --}}
                                                    <button
                                                        class="h6 btn btn-sm btn-primary text-white bsb-hover-fadeInRight mt-2">Read
                                                        More</button>
                                                </figcaption>
                                            </figure>
                                            <div class="card-body m-0 p-0">
                                                <div class="entry-header mb-3">
                                                    <ul class="entry-meta list-unstyled d-flex mb-3">
                                                        <li>
                                                            <a class="d-inline-flex px-2 py-1 btn btn-outline-primary text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-2 text-decoration-none fs-7"
                                                                href="{{ route('category_posts', $popularPost->post_category->slug) }}">{{ $popularPost->post_category->name }}</a>
                                                        </li>
                                                    </ul>
                                                    <h3 class="card-title entry-title h5 m-0">
                                                        <a class="post-title"
                                                            href="{{ route('read_post', $popularPost->slug) }}">{{ $popularPost->title }}</a>
                                                    </h3>
                                                </div>
                                            </div>
                                            <div class="card-footer border-0 bg-transparent p-0 m-0">
                                                <ul class="entry-meta list-unstyled d-flex align-items-center m-0">
                                                    <li>
                                                        <span
                                                            class="text-primary text-decoration-none d-flex align-items-center">
                                                            <i class="fa fa-calendar mr-1"></i>
                                                            <span>{{ dateFormatter($popularPost->created_at) }}</span>
                                                        </span>
                                                    </li>
                                                    <li>
                                                        <span class="px-2"></span>
                                                    </li>
                                                    <li>
                                                        <span
                                                            class="text-primary text-decoration-none d-flex align-items-center">
                                                            <i class="fa fa-comment mr-1"></i>
                                                            <span>{{ $popularPost->comments_count }}</span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
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

            <div class="d-flex align-items-center justify-content-center" {{--  ad-container --}} {{-- style="background-color: #655087; height: 200px;" --}}>
                @php
                    $cornerAd = getCornerAd();
                @endphp
                @if ($cornerAd)
                    <div class="w-100 h-100 rounded-lg">
                        @if ($cornerAd->image && $cornerAd->url)
                            {{-- Show image wrapped in a link --}}
                            <a href="{{ e($cornerAd->url) }}" target="_blank" rel="noopener noreferrer">
                                <img src='{{ asset("images/ads/{$cornerAd->image}") }}' alt="Ad"
                                    class="img-fluid">
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
@push('scripts')
    <script>
        $('.post-slider').on('afterChange', function(event, slick, currentSlide) {
            // Remove focus from hidden slides
            $('.slick-slide[aria-hidden="true"] a, .slick-slide[aria-hidden="true"] button')
                .attr('tabindex', '-1');

            // Restore focus to visible slide
            $('.slick-slide[aria-hidden="false"] a, .slick-slide[aria-hidden="false"] button')
                .removeAttr('tabindex');
        });
    </script>
@endpush
