@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Document title')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-8 mb-5 mb-lg-0">
            <article class="row mb-4">
                <div class="col-lg-12 mb-2">
                    <h2 class="mb-3">{{ $post->title }}</h2>
                    <ul class="list-inline post-meta">
                        <li class="list-inline-item"><i class="ti-user mr-2"></i><a
                                href="{{ route('author_posts', $post->author->username) }}">{{ $post->author->name }}</a>
                        </li>
                        <li class="list-inline-item"><i class="ti-calendar mr-1"></i> {{ dateFormatter($post->created_at) }}
                        </li>
                        <li class="list-inline-item"><i class="ti-folder"></i> <a
                                href="{{ route('category_posts', $post->post_category->slug) }}"
                                class="ml-1">{{ $post->post_category->name }}</a>
                        </li>
                        <li class="list-inline-item"><i class="ti-timer mr-1">
                            </i>
                            {{ readDuration($post->title, $post->content) }} @choice('min|mins', readDuration($post->title, $post->content))
                        </li>
                        <li class="list-inline-item">
                            <i class="ti-eye mr-1"></i>{{ $post->views_count }} Views
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
                                    class="img-fluid rounded-lg" alt="{{ $relatedPost->title }}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4>
                                <a class="post-title" href="{{ route('read_post', $relatedPost->slug) }}">
                                    {{ $relatedPost->title }}
                                </a>
                            </h4>
                            <ul class="list-inline post-meta mb-2">
                                <li class="list-inline-item">
                                    <i class="ti-user mr-1"></i><a
                                        href="{{ route('author_posts', $relatedPost->author->username) }}">{{ $relatedPost->author->name }}</a>
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-calendar mr-1"></i>{{ dateFormatter($relatedPost->created_at) }}
                                </li>
                                <li class="list-inline-item">
                                    <i class="ti-folder"></i> <a href="{{ route('category_posts', $relatedPost->post_category->slug) }}"
                                        class="ml-1">{{ $relatedPost->post_category->name }} </a>
                                </li>
                                <li class="list-inline-item"><i class="ti-timer mr-1">
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
                <div id="disqus_thread"></div>
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
                </script>
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
                <ul class="list-unstyled widget-list latest-article">
                    @foreach (sidebarLatestPosts(5, $post->id) as $sidebarLatestPost)
                        <li class="media widget-post align-items-center letest-result-item">
                            <a href="{{ route('read_post', $sidebarLatestPost->slug) }}">
                                <img loading="lazy" class="mr-3"
                                    src='{{ asset("storage/images/posts/resized/resized_$sidebarLatestPost->feature_image") }}'>
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
