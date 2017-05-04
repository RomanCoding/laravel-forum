<div class="panel panel-default">
    <div class="panel-heading">
        Created thread
        <a href="{{ $activity->subject->path() }}">
            {{ $activity->subject->title }}
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