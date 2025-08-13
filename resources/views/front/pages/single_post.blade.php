@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Document title')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection
@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('front/css/post_comments.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-8 mb-5 mb-lg-0">
            <article class="row mb-4">
                <div class="col-lg-12 mb-2">
                    <h2 class="mb-3">{{ $post->title }}</h2>
                    <ul class="list-inline post-meta text-primary">
                        <li class="list-inline-item">
                            <a class="text-primary" href="{{ route('author_posts', $post->author->username) }}">
                                <img src='{{ asset($post->author->picture) }}' loading="lazy" alt="User Avatar"
                                    class="profile-avatar mr-1 mb-1" width="10" height="10">{{ $post->author->name }}</a>
                        </li>
                        <li class="list-inline-item"><i class="ti-calendar mr-1"></i> {{ dateFormatter($post->created_at) }}
                        </li>
                        <li class="list-inline-item"><i class="ti-folder"></i> <a
                                href="{{ route('category_posts', $post->post_category->slug) }}"
                                class="text-primary ml-1">{{ $post->post_category->name }}</a>
                        </li>
                        <li class="list-inline-item">
                            <i class="ti-timer mr-1"></i>
                            {{ readDuration($post->title, $post->content) }} @choice('min|mins', readDuration($post->title, $post->content))
                        </li>
                        <li class="list-inline-item">
                            <i class="ti-eye mr-1"></i>
                            {{ $post->views_count }}
                        </li>
                        <li class="list-inline-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                class="bi bi-chat-dots text-sm mr-1 mb-1" viewBox="0 0 16 16">
                                <path
                                    d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                <path
                                    d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z" />
                            </svg>{{ $post->comments_count }}
                        </li>
                    </ul>
                </div>
                <div class="col-12 mb-3">
                    <img src='{{ asset("storage/images/posts/{$post->feature_image}") }}' alt="{{ $post->title }}"
                        class="img-fluid rounded-lg">
                </div>
                <!-- SHARE BUTTONS -->
                <div class="share-buttons">
                    <span class="title-color">Share: </span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('read_post', $post->slug)) }}"
                        target="_blank" class="btn-facebook">
                        <i class="ti-facebook"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('read_post', $post->slug)) }}&amp;text={{ urlencode($post->title) }}"
                        target="_blank" class="btn-twitter">
                        <i class="ti-twitter-alt"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('read_post', $post->slug)) }}"
                        target="_blank" class="btn-linkedin">
                        <i class="ti-linkedin"></i>
                    </a>
                    <a href="https://www.pinterest.com/pin/create/button/?url={{ urlencode(route('read_post', $post->slug)) }}&description={{ urlencode($post->title) }}"
                        target="_blank" class="btn-pinterest">
                        <i class="ti-pinterest"></i>
                    </a>
                    <a href="mailto:?subject={{ urlencode("Check out this post: {$post->title}") }}&amp;body={{ urlencode('i found this interesting post: ' . route('read_post', $post->slug)) }}"
                        target="_blank" class="btn-email">
                        <i class="ti-email"></i>
                    </a>
                </div>
                <!-- SHARE BUTTONS -->
                <div class="col-lg-12">
                    <div class="content">
                        {!! $post->content !!}
                    </div>
                </div>
            </article>
            <div class="prev-next-posts mt-3 mb-3">
                <div class="row justify-content-between p-4">
                    <div class="col-md-6 mb-2">
                        @if ($prevPost)
                            <div>
                                <h6>« Previous</h6>
                                <a href="{{ route('read_post', $prevPost->slug) }}">{{ $prevPost->title }}</a>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6 mb-2 text-md-right">
                        @if ($nextPost)
                            <div>
                                <h6>Next »</h6>
                                <a href="{{ route('read_post', $nextPost->slug) }}">{{ $nextPost->title }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <section class="latest-article">
                <h4>Related Posts</h4>
                <hr>
                @foreach ($relatedPosts as $relatedPost)
                    <article class="row mb-5 mt-4 letest-result-item">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="post-img-box">
                                <img src='{{ asset("/storage/images/posts/resized/resized_{$relatedPost->feature_image}") }}'
                                    class="img-fluid rounded-lg" width="1200" height="650"
                                    alt="{{ $relatedPost->title }}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4>
                                <a class="post-title" href="{{ route('read_post', $relatedPost->slug) }}">
                                    {{ $relatedPost->title }}
                                </a>
                            </h4>
                            <ul class="list-inline post-meta text-primary mb-2">
                                <li class="list-inline-item">
                                    <img src='{{ asset($post->author->picture) }}' loading="lazy" alt="User Avatar"
                                    class="profile-avatar mb-1" width="10" height="10">
                                    <a class="text-primary"
                                        href="{{ route('author_posts', $relatedPost->author->username) }}">{{ $relatedPost->author->name }}</a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-calendar mr-1"></i>{{ dateFormatter($relatedPost->created_at) }}
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-folder"></i> <a
                                        href="{{ route('category_posts', $relatedPost->post_category->slug) }}"
                                        class="text-primary">{{ $relatedPost->post_category->name }} </a>
                                </li>
                                <li class="list-inline-item"><i class="ti-timer">
                                    </i>
                                    {{ readDuration($relatedPost->title, $relatedPost->content) }} @choice('min|mins', readDuration($relatedPost->title, $relatedPost->content))
                                </li>
                            </ul>
                            <p>
                                {!! Str::ucfirst(words($relatedPost->content, 28)) !!}
                            </p>
                            <a href="{{ route('read_post', $relatedPost->slug) }}" class="btn btn-outline-primary">Read
                                more...</a>
                        </div>
                    </article>
                @endforeach
            </section>

            <section class="comments">
                @livewire('post-comments', ['postId' => $post->id])
                {{-- <div id="disqus_thread"></div>
                <script>
                    /**
                     *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                     *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
                    /*
                     */
                    var disqus_config = function() {
                        this.page.url =
                            "{{ route('read_post', $post->slug) }}"; // Replace PAGE_URL with your page's canonical URL variable
                        this.page.identifier = "PID_" +
                            "{{ $post->id }}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                    };

                    (function() { // DON'T EDIT BELOW THIS LINE
                        var d = document,
                            s = d.createElement('script');
                        s.src = 'https://devcplus.disqus.com/embed.js';
                        s.setAttribute('data-timestamp', +new Date());
                        (d.head || d.body).appendChild(s);
                    })();
                </script> --}}
            </section>
        </div>
        <aside class="col-lg-4">
            <!-- Search Component -->
            <livewire:search-component />

            <!-- categories -->
            <x-sidebar-categories />

            <!-- tags -->
            <x-sidebar-tags />

            <!-- latest post -->
            <div class="widget">
                <h5 class="widget-title"><span>Latest Article</span></h5>
                <!-- post-item -->
                <ul class="list-unstyled widget-list latest-article text-primary">
                    @foreach (sidebarLatestPosts(5, $post->id) as $sidebarLatestPost)
                        <li class="media widget-post align-items-center letest-result-item">
                            <a href="{{ route('read_post', $sidebarLatestPost->slug) }}"
                                aria-label="Latest Article {{ $sidebarLatestPost->title }}">
                                <img loading="lazy" class="mr-3"
                                    src='{{ asset("storage/images/posts/resized/resized_$sidebarLatestPost->feature_image") }}'
                                    alt="{{ $sidebarLatestPost->title }}">
                            </a>
                            <div class="media-body">
                                <h6 class="mb-0">
                                    <a
                                        href="{{ route('read_post', $sidebarLatestPost->slug) }}">{{ $sidebarLatestPost->title }}</a>
                                </h6>
                                <small><i class="ti-calendar mr-1"></i>
                                    {{ dateFormatter($sidebarLatestPost->created_at) }}</small>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.share-buttons > a', function(e) {
            e.preventDefault();
            window.open($(this).attr('href'), '', 'height=450,width=450,top=' + ($(window).height() / 2 - 275) +
                ', left=' + ($(window).width() / 2 - 225) +
                ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');

            return false;
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.content pre').forEach(function(pre) {
                // Skip if already has a copy button
                if (pre.querySelector('.copy-button')) return;

                const code = pre.querySelector('code');
                if (!code) return;

                // Create the copy button inside <pre>
                const button = document.createElement('button');
                button.className = 'copy-button';
                button.innerHTML = '📋';

                pre.appendChild(button); // append inside <pre>

                button.addEventListener('click', function() {
                    const text = code.innerText;

                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    document.body.appendChild(textarea);
                    textarea.select();

                    try {
                        document.execCommand('copy');
                        button.innerHTML = '✅';
                    } catch (err) {
                        button.innerHTML = '❌';
                    }

                    document.body.removeChild(textarea);
                    setTimeout(() => button.innerHTML = '📋', 1500);
                });
            });
        });
    </script>
@endpush
