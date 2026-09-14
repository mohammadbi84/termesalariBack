<div class="article-search-results">

    @if ($articles->count())

        @foreach ($articles as $article)
            <a href="{{ route('article.show', $article->id) }}" class="article-search-result">

                <div class="article-search-result-image">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}">
                </div>

                <div class="article-search-result-info">
                    <span class="article-search-result-title">
                        {{ $article->title }}
                    </span>
                    <span class="article-search-result-date">
                        <i class="bi bi-calendar3"></i>
                        {{ Verta($article->created_at)->format('%d %B %Y') }}
                    </span>
                </div>

            </a>
        @endforeach
    @else
        <div class="article-search-empty">
            <i class="bi bi-search"></i>
            {{ __('article.no_article_found') }}
        </div>
    @endif

</div>
