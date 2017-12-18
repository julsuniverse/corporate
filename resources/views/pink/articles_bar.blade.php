<div class="widget-first widget recent-posts">
    <h3>{{ trans('ru.latest_portfolios') }}</h3>
    <div class="recent-post group">
        @if(!$portfolios->isEmpty())
            @foreach($portfolios as $port)
                <div class="hentry-post group">
                    <div class="thumb-img"><img style="width: 55px;" src="{{ asset(env('THEME')) }}/images/projects/{{ $port->img->mini }}" alt="001" title="001" /></div>
                    <div class="text">
                        <a href="{{ route('portfolios.show', ['alias' => $port->alias]) }}" title="Section shortcodes &amp; sticky posts!" class="title">{{ $port->title }}</a>
                        {!! str_limit($port->text, 130) !!}
                        <a class="read-more" href="{{ route('portfolios.show', ['alias' => $port->alias]) }}">&rarr; {{ trans('ru.read_more') }}</a>
                    </div>
                </div>
            @endforeach
        @endif

    </div>
</div>

<div class="widget-last widget recent-comments">
    <h3>{{ trans('ru.latest_comments') }}</h3>
    <div class="recent-post recent-comments group">
        @if(!$comments->isEmpty())
            @foreach($comments as $comment)
                <div class="the-post group">
                    <div class="avatar">
                        @set($hash, ($comment->email) ? md5($comment->email) : $comment->user->email)
                        <img alt="" src="https://www.gravatar.com/avatar/{{$hash}}?d=mm&s=55" class="avatar" />
                    </div>
                    <span class="author"><strong><a href="#">{{ isset($comment->user) ? $comment->user->name : $comment->name }}</a></strong> in</span>
                    <a class="title" href="{{ route('articles.show', ['alias' => $comment->article->alias]) }}">
                        {{ $comment->article->title }}
                    </a>
                    <p class="comment">
                        {{ $comment->text }} <a class="goto" href="{{ route('articles.show', ['alias' => $comment->article->alias]) }}">&#187;</a>
                    </p>
                </div>
            @endforeach

        @endif

    </div>
</div>
