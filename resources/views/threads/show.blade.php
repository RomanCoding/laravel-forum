@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>


                @foreach ($replies as $reply)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="#">
                                {{ $reply->owner->name }}
                            </a> said {{ $reply->created_at->diffForHumans() }}...
                        </div>

                        <div class="panel-body">
                            {{ $reply->body }}
                        </div>

                        <form action="/likes/reply/{{$reply->id}}"   method="POST">
                            {{ csrf_field() }}
                            <button type="submit" class="btn-primary btn-xs btn-info">Like
                                <span class="fa fa-heart"></span>
                                {{ $reply->likes_count }}
                            </button>
                        </form>

                    </div>
                @endforeach

                {{ $replies->links() }}

                @if(auth()->check())
                    <form action="{{ $thread->path() }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" class="form-control" placeholder="Write you reply here..."></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Reply</button>
                        </div>
                    </form>
                @else
                    <p class="text-center"><a href="/login">Sign in</a> to participate in discussion.</p>
                @endif

            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Posted by <a href="#">{{ $thread->creator->name }}</a> {{ $thread->created_at->diffForHumans() }}
                    </div>

                    <div class="panel-body">
                        This thread has {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
