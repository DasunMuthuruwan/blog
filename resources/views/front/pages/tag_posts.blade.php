@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Document title')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection
@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('front/css/category_posts.css') }}">
@endpush
@section('content')
    <div class="w-full mb-6">
        <h3 class="text-2xl font-semibold title-color dark:text-gray-200">{{ $pageTitle }}</h3>
    </div>

    @if ($posts->count() > 0)
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-6">
                    <article class="post-container h-full bg-white rounded-lg overflow-hidden shadow-sm">
                        <a href="{{ route('read_post', $post->slug) }}" class="block post-image-wrapper">
                            <img loading="lazy" src='{{ asset("storage/images/posts/resized/resized_$post->feature_image") }}'
                                alt="{{ $post->title }}" class="post-image">
                        </a>

                        <div class="p-2">
                            <h5 class="mb-2">
                                <a class="post-title text-lg" href="{{ route('read_post', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <ul class="list-inline post-meta text-xs">
                                <li class="list-inline-item"><i class="ti-calendar mr-1"></i>
                                    {{ dateFormatter($post->created_at) }}</li>
                                <li class="list-inline-item">
                                    <i class="ti-user mr-1"></i>
                                    <a href="{{ route('author_posts', $post->author->username) }}" class="author-link">
                                        {{ $post->author->name }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <span class="text-gray-500 dark:text-gray-400">No posts found in this tag</span>
        </div>
    @endif

    <div class="pagination-block mt-8">
        {{ $posts->appends(request()->input())->links('custom-paginations') }}
    </div>

@endsection
@push('scripts')
    <script>
        // JavaScript to control card hover states when author link is hovered
        document.addEventListener('DOMContentLoaded', function() {
            const authorLinks = document.querySelectorAll('.author-link');

            authorLinks.forEach(link => {
                const postContainer = link.closest('.post-container');

                // When hovering over author link, add class to disable card hover effects
                link.addEventListener('mouseenter', function() {
                    postContainer.classList.add('author-hovered');
                });

                // When leaving author link, remove class to re-enable card hover effects
                link.addEventListener('mouseleave', function() {
                    postContainer.classList.remove('author-hovered');
                });
            });
        });
    </script>
@endpush
