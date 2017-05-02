<div class="panel panel-default">
    <div class="panel-heading">
        <a href="{{ $thread->path() }}">
            {{ $thread->title }}
        </a>
        <div class="pull-right">
            {{ $thread->created_at->diffForHumans() }} by <a
                    href="{{ $thread->creator->profile() }}">{{ $thread->creator->name }}</a>
        </div>
    </div>

    <div class="panel-body">
        <article>
            <div class="body">{{ $thread->body }}</div>

            <a href="#" class="pull-right">
                {{ str_plural('Reply', $thread->replies_count) }}
                <span class="badge">{{ $thread->replies_count }}</span>
            </a>
        </article>
    </div>
</div>