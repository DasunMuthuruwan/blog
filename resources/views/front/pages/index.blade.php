@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Document title')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-8  mb-5 mb-lg-0">

            <article class="row mb-5">
                <div class="col-12">
                    <div class="post-slider">
                        <div class="slider-item">
                            <img loading="lazy" src="{{ asset('front/images/posts/11.png') }}" class="img-fluid"
                                alt="post-thumb">
                            <div class="slider-content">
                                <h2 class="animate__animated">JavaScript ES6: Arrow Functions Explained</h2>
                            </div>
                        </div>
                        <div class="slider-item">
                            <img loading="lazy" src="{{ asset('front/images/posts/02.png') }}" class="img-fluid"
                                alt="post-thumb">
                            <div class="slider-content">
                                <h2 class="animate__animated">CSS Flexbox: Aligning Elements Like a Pro
                                </h2>
                            </div>
                        </div>
                        <div class="slider-item">
                            <img loading="lazy" src="{{ asset('front/images/posts/03.png') }}" class="img-fluid"
                                alt="post-thumb">
                            <div class="slider-content">
                                <h2 class="animate__animated">Optimizing Applications for Speed</h2>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    href="{{ route('category_posts', $post->post_category->slug) }}" class="ml-1">
                                    {{ $post->post_category->name }}
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <i class="ti-timer mr-1">
                                    {{ readDuration($post->title, $post->content) }}
                                    @choice('min|mins', readDuration($post->title, $post->content))
                                </i>
                                </a>
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

            <section id="home__latest-posts">
                @foreach (latestPosts(1, 3) as $latestPost)
                    <article class="row mb-5">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="post-img-box">
                                <img src='{{ asset("storage/images/posts/resized/resized_$latestPost->feature_image") }}''
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
                                        href="{{ route('category_posts', $latestPost->post_category->id) }}"
                                        class="ml-1">
                                        {{ $latestPost->post_category->name }}
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-timer mr-1">
                                        {{ readDuration($latestPost->title, $latestPost->content) }}
                                        @choice('min|mins', readDuration($latestPost->title, $latestPost->content))
                                    </i>
                                    </a>
                                </li>
                            </ul>
                            <p>
                                {!! Str::ucfirst(words($latestPost->content, 30)) !!}
                            </p>
                            <a href="{{ route('read_post', $latestPost->slug) }}" class="btn btn-outline-primary">Read
                                more...</a>
                        </div>
                    </article>
                @endforeach
            </section>

        </div>
        <aside class="col-lg-4">
            <!-- Search -->
            <x-sidebar-search />
            
            <!-- categories -->
            <x-sidebar-categories />

            <!-- tags -->
            <x-sidebar-tags />

            <!-- latest post -->
            <div class="widget">
                <h5 class="widget-title"><span>Latest Article</span></h5>
                <!-- post-item -->
                <ul class="list-unstyled widget-list">
                    <li class="media widget-post align-items-center">
                        <a href="post-details.html">
                            <img loading="lazy" class="mr-3" src="{{ asset('front/images/posts/05.png') }}">
                        </a>
                        <div class="media-body">
                            <h6 class="mb-0">
                                <a href="post-details.html">Optimizing CodeIgniter Applications for Speed.</a>
                            </h6>
                            <small>June 10, 2024</small>
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled widget-list">
                    <li class="media widget-post align-items-center">
                        <a href="post-details.html">
                            <img loading="lazy" class="mr-3" src="{{ asset('front/images/posts/06.png') }}">
                        </a>
                        <div class="media-body">
                            <h6 class="mb-0"><a href="post-details.html">CSS Animations: Adding Life to Your Web
                                    Page</a>
                            </h6>
                            <small>June 27, 2024</small>
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled widget-list">
                    <li class="media widget-post align-items-center">
                        <a href="post-details-2.html">
                            <img loading="lazy" class="mr-3" src="{{ asset('front/images/posts/07.png') }}">
                        </a>
                        <div class="media-body">
                            <h6 class="mb-0"><a href="post-details-2.html">PHP Error Handling: Best Practices
                                    for Beginners</a>
                            </h6>
                            <small>June 03, 2024</small>
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled widget-list">
                    <li class="media widget-post align-items-center">
                        <a href="post-details-2.html">
                            <img loading="lazy" class="mr-3" src="{{ asset('front/images/posts/08.png') }}">
                        </a>
                        <div class="media-body">
                            <h6 class="mb-0"><a href="post-details-2.html">Secure User Authentication with
                                    PHP</a>
                            </h6>
                            <small>June 03, 2024</small>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center justify-content-center"
                style="background-color: #655087; height: 200px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 600" class="w-100 h-100 rounded-lg">
                    <rect width="100%" height="100%" fill="#655087" />
                    <text x="50%" y="50%" fill="white" font-size="36" font-family="Arial, sans-serif"
                        text-anchor="middle" dy=".3em">
                        Ad Space
                    </text>
                </svg>
            </div>
        </aside>
    </div>
@endsection
