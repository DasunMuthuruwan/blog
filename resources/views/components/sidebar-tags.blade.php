<div>
    <div class="widget">
        <h5 class="widget-title"><span>Tags</span></h5>
        <ul class="list-inline widget-list-inline post-tags">
            @foreach (getTags(15) as $tag)
                <li class="list-inline-item">
                    <a href="{{ route('tag_posts', urlencode($tag)) }}" class="tag-badge">#{{ $tag }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
