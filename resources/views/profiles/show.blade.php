@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <ul class="list-group">
                <li class="list-group-item"><b>User's name:</b> {{ $user->name }}</li>
                <li class="list-group-item"><b>Registered:</b> {{ $user->created_at->diffForHumans() }}</li>
                <li class="list-group-item"><b>Threads created:</b> <a
                            href="/threads?by={{ $user->name }}">{{ $user->threads_count }}</a></li>
                <li class="list-group-item"><b>Replies:</b> {{ $user->replies_count }}</li>
                <li class="list-group-item"><b>Likes earned:</b> {{ $user->likes_count }}</li>
            </ul>
            @if (count($activities))
                <h2>Last activity</h2>
                @foreach ($activities as $date => $entries)
                    <div class="page-header">
                        {{ $date }}
                    </div>
                    @foreach($entries as $activity)
                        @include("profiles.activities.{$activity->activity}")
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
@endsection
