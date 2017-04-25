@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Forum Threads</div>

                    <div class="panel-body">
                        @foreach ($threads as $thread)
                            <article>
                                <h4>
                                    <a href="{{ $thread->path() }}">
                                        {{ $thread->title }}
                                    </a>
                                </h4>
                                <div class="body">{{ $thread->body }}</div>

                                <a href="#" class="pull-right">
                                    {{ str_plural('Reply', $thread->replies_count) }}
                                    <span class="badge">{{ $thread->replies_count }}</span>
                                </a>

                            </article>

                            <hr>
                        @endforeach

                        {{ $threads->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
