@component('profiles.activities.activity')
    @slot('heading')
        Created thread
        <a href="{{ $activity->subject->path() }}">
            {{ $activity->subject->title }}
        </a>
        <div class="pull-right">
            {{ $activity->subject->created_at->diffForHumans() }}
        </div>
    @endslot

    @slot('body')
        <div class="body">{{ $activity->subject->body }}</div>
    @endslot
@endcomponent