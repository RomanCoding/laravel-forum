<div class="panel panel-default">
    <div class="panel-heading">
        Replied in
        <a href="{{ $activity->subject->thread->path() }}">
            {{ $activity->subject->thread->title }}
        </a>
        <div class="pull-right">
            {{ $activity->subject->created_at->diffForHumans() }}
        </div>
    </div>

    <div class="panel-body">
        <article>
            <div class="body">{{ $activity->subject->body }}</div>
        </article>
    </div>
</div>