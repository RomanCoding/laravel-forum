@component('profiles.activities.activity')
    @slot('heading')
        Liked a reply in
        <a href="{{ $activity->subject->liked->thread->path() }}">
            {{ $activity->subject->liked->thread->title }}
        </a>
        <div class="pull-right">
            {{ $activity->subject->liked->created_at->diffForHumans() }}
        </div>
    @endslot

    @slot('body')
        <div class="body">{{ $activity->subject->liked->body }}</div>
    @endslot
@endcomponent