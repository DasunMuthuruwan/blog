<div>
    <div class="widget">
        <h5 class="widget-title"><span>Latest Article</span></h5>
        <!-- post-item -->
        <ul class="list-unstyled widget-list latest-article text-primary">
            @foreach (sidebarLatestPosts() as $sidebarLatestPost)
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
</div>
