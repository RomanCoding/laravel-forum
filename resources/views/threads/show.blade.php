@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/threads">Forum</a></li>
            <li><a href="{{ $thread->channel->path() }}">{{ $thread->channel->name }}</a></li>
            <li class="active"><a href="{{ $thread->path() }}">{{ $thread->title }}</a></li>
        </ol>
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ $thread->creator->profile() }}">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}
                        @can('delete', $thread)
                            <form action="{{ $thread->path() }}" class="pull-right" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-link" type="submit">Delete thread</button>
                            </form>
                        @endcan
                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @foreach ($replies as $reply)
                    @include('replies._panel')
                @endforeach

                {{ $replies->links() }}

                @if($auth)
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
                        Posted by <a
                                href="{{ $thread->creator->profile() }}">{{ $thread->creator->name }}</a> {{ $thread->created_at->diffForHumans() }}
                    </div>

                    <div class="panel-body">
                        This thread has {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
