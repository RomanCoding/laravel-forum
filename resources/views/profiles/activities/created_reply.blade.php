@component('profiles.activities.activity')
    @slot('heading')
        Replied in
        <a href="{{ $activity->subject->thread->path() }}">
            {{ $activity->subject->thread->title }}
        </a>
        <div class="pull-right">
            {{ $activity->subject->created_at->diffForHumans() }}
        </div>
    @endslot

    @slot('body')
        <div class="body">{{ $activity->subject->body }}</div>
    @endslot
@endcomponent