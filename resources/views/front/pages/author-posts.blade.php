@extends('front.layout.pages-layout')
@section('pageTitle', $pageTitle ?? 'Document title')
@section('meta_tags')
    {!! SEO::generate(true) !!}
@endsection

@section('content')
    <section class="section-sm border-bottom pb-3 pt-3">
        <div class="container">
            <!-- Author Profile -->
            <div class="author-card text-center">
                <img src="{{ asset($author->picture) }}" alt="Author's Photo" class="rounded-full w-24 h-24 mx-auto object-cover">
                <h3 class="mt-3 title-color font-semibold text-xl">{{ $author->name }}</h3>
                <p class="text-gray-600">{{ $author->username }}</p>
                <p class="text-gray-700 max-w-2xl mx-auto mt-2">
                    {{ $author->bio ?? 'A passionate writer sharing knowledge and experiences.' }}
                </p>

                @if ($author->social_links)
                    <div class="social-links mt-4 flex justify-center gap-4">
                        @foreach (['facebook', 'github', 'linkedin', 'twitter', 'instagram', 'youtube'] as $social)
                            @if ($author->social_links->{"{$social}_url"})
                                <a href="{{ $author->social_links->{"{$social}_url"} }}" target="_blank"
                                    class="text-gray-500 hover:text-blue-500" title="{{ ucfirst($social) }}">
                                    <i class="ti-{{ $social }} text-xl"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="section-sm mt-0 pt-4">
        <div class="container">
            <div class="row">
                @forelse ($posts as $post)
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                        <article class="post-container h-full bg-white rounded-lg overflow-hidden shadow-sm">
                            <a href="{{ route('read_post', $post->slug) }}" class="block post-image-wrapper">
                                <img loading="lazy"
                                    src='{{ asset("storage/images/posts/resized/resized_$post->feature_image") }}'
                                    alt="{{ $post->title }}" class="post-image">
                            </a>

                            <div class="p-2">
                                <h5 class="mb-2">
                                    <a class="post-title font-medium text-lg" href="{{ route('read_post', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                <ul class="list-inline post-meta text-xs text-gray-500">
                                    <li class="list-inline-item">
                                        <i class="ti-calendar mr-1"></i> {{ dateFormatter($post->created_at) }}
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="{{ route('category_posts', $post->post_category->slug) }}"
                                            class="hover:text-blue-500 category-link">
                                            <i class="ti-folder mr-1"></i> {{ $post->post_category->name }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12 text-center py-8">
                        <span class="text-gray-500">
                            No posts found for this author!
                        </span>
                    </div>
                @endforelse
            </div>

            <div class="pagination-block mt-6">
                {{ $posts->appends(request()->input())->links('custom-paginations') }}
            </div>
        </div>
    </section>
@endsection
@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('front/css/author_posts.css') }}">
@endpush
@push('scripts')
    <script>
        // JavaScript to control card hover states when author link is hovered
        document.addEventListener('DOMContentLoaded', function() {
            const authorLinks = document.querySelectorAll('.category-link');

            authorLinks.forEach(link => {
                const postContainer = link.closest('.post-container');

                // When hovering over author link, add class to disable card hover effects
                link.addEventListener('mouseenter', function() {
                    postContainer.classList.add('category-hovered');
                });

                // When leaving author link, remove class to re-enable card hover effects
                link.addEventListener('mouseleave', function() {
                    postContainer.classList.remove('category-hovered');
                });
            });
        });
    </script>
@endpush
