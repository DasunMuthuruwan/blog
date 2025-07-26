<div>
    <div class="widget">
        <h5 class="widget-title"><span>Search</span></h5>
        <form action="{{ route('search_posts') }}" method="GET" class="widget-search">
            <input id="search-query" name="s" type="search"
            value="{{ request('p') ?: '' }}"
                placeholder="Type to discover articles, guide &amp; tutorials...">
            <button type="submit"><i class="ti-search"></i>
            </button>
        </form>
    </div>est battle is the war against ignorance. - Mustafa Kemal Atatürk -->
</div>
