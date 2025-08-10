<div>
    <div class="widget">
        <h5 class="widget-title"><span>Categories</span></h5>
        <ul class="list-unstyled widget-list">
            @foreach (sidebarCategories() as $item)
                <li><a href="{{ route('category_posts', $item->slug) }}" class="d-flex">
                        {{ $item->name }}
                        <small class="ml-auto"><span class="badge badge-primary">{{ $item->posts_count }}</span></small></a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
